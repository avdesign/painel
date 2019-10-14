<?php

namespace AVDPainel\Http\Controllers\Admin;

use AVDPainel\Http\Controllers\Controller;

use AVDPainel\Models\Admin\Brand;
use AVDPainel\Models\Admin\Product;
use AVDPainel\Models\Admin\Section;
use AVDPainel\Models\Admin\Category;
use AVDPainel\Models\Admin\ImageColor;
use AVDPainel\Models\Admin\Contact;

use AVDPainel\Interfaces\Admin\AdminAccessInterface as InterAccess;
use AVDPainel\Interfaces\Admin\ConfigAdminInterface as InterConfigAvatar;
use AVDPainel\Interfaces\Admin\ConfigSystemInterface as InterConfigSystem;


class PainelController extends Controller
{
    protected $last_url;
    protected $sidbar;
    protected $phat_url;
    protected $avatar_url;


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        InterAccess $access,
        InterConfigAvatar $interConfigAvatar,
        InterConfigSystem $interConfigSystem)
    {
        $this->middleware('auth:admin');

        $this->access            = $access;

        $this->interConfigSystem = $interConfigSystem;
        $this->interConfigAvatar = $interConfigAvatar->setId(1);
        $this->avatar_url        = 'https://www.gravatar.com/avatar';
        $this->phat_url          = 'storage/';

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(
        Brand $brand,
        Contact $contact,
        Section $section,
        Product $product,
        Category $category,
        ImageColor $colors)

    {

        $this->last_url   = array("last_url" => "");


        $photos = auth()->user()->photo;

        $width    = $this->interConfigAvatar->width_photo;
        $height   = $this->interConfigAvatar->height_photo;
        $path     = $this->phat_url.$this->interConfigAvatar->path.$width.'x'.$height.'/';

        $photos = auth()->user()->photo;

        $avatar = $this->avatar_url;
        foreach ($photos as $photo) {
            if ($photo->status == 'Ativo' && $photo->image != '') {
                $avatar = $path. $photo->image;
            }
        }

        $sidebar  = array(
            'total_brands' => $brand->count(),
            'total_sections' => $section->count(),
            'total_categories' => $category->count(),
            'total_products' => $product->count(),
            'total_colors' => $colors->count(),
            'total_mails' => $contact->where('send', 0)->count()
        );

        $this->access->update($this->last_url);

        return view('backend.home.index', compact('sidebar', 'avatar'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function home()
    {

        $this->last_url = array("last_url" => "admin");
        $this->access->update($this->last_url);
        return view('backend.home.home');
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function menu(Section $section)
    {
        $sections = $section->get();

        return view('backend.includes.sidebar.menu', compact('sections'));
    }


}
