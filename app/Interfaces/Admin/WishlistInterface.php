<?php

namespace AVDPainel\Interfaces\Admin;

interface WishlistInterface
{
    /**
     * Interface model Wishlist
     *
     * @return \AVDPainel\Repositories\Admin\WishlistRepository
     */
    public function get();
    public function setId($id);
    public function getAll($request);
    public function getWishlist($user_id);
    public function create($request, $user, $color, $configProduct);
    public function update($input, $id);
    public function delete($id);
    public function deleteAll($user_id);


    public function rules($input, $messages, $id);

}