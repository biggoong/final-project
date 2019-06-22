<?php

class posts
{
    protected $db;

    public function __construct()
    {
        $this->db = sql::getInstance();
    }

    public function createPost($post, $image, $user_id)
    {
        $post['user_id'] = $user_id;
        $post['image_url'] = $image;
        $post['short_desc'] = substr($post['text'], 0, 90) . '...';
        $this->db->insert('posts', $post);
    }

    public function selectAllPosts()
    {
        $posts = [];
        $posts['posts'] = $this->db->select_join('posts', 
        'post_id, title, short_desc, publication_time, image_url, likes, dislikes, posts.user_id, users.nickname', 
        'users', 'users.user_id = posts.user_id', [],' ORDER by posts.likes DESC');
        $posts['comments_count'] = $this->db->select_join('posts', 
        'DISTINCT posts.post_id, (count(comments.text) OVER (PARTITION BY comments.post_id)) as comments_count',
        'comments', 'posts.post_id = comments.post_id');
        return $posts;
    }

    public function selectAllPostsByUser($user_id)
    {
        return $this->db->select('posts', '*', ['user_id' => $user_id]);
    }

    public function selectPost($post_id)
    {
        return $this->db->select_join('posts', 
        'post_id, title, text, publication_time, image_url, likes, dislikes, posts.user_id, users.nickname', 
        'users', 'users.user_id = posts.user_id', ['post_id' => $post_id]);
    }

    public function editPost($post, $image, $post_id)
    {
        if (!empty($image)) {
            $post['image_url'] = $image;
        };
        $this->db->update('posts', $post, ['post_id' => $post_id]);
    }

    public function deletePost($post_id)
    {
        $this->db->delete('posts', ['post_id' => $post_id]);
    }

    public function createComment($comment)
    {
        $this->db->insert('comments', $comment);
    }

    public function selectComments($post_id)
    {
        return $this->db->select_join('comments', 
        'comment_id, text, publication_time, comments.user_id, post_id, users.nickname', 
        'users', 'comments.user_id = users.user_id',
        ['post_id' => $post_id]);
    }

}
