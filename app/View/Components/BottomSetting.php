<?php

namespace App\View\Components;

use Illuminate\View\Component;

class BottomSetting extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        $bottomMenuJson = '{ "pageSettingList":[{"title":"Scroll Top","icon" : "fal fa-arrow-up", "link" : "#"},{"title":"Logout","icon" : "fal fa-sign-out", "link" : "/logout"},{"title":"Full Screen", "icon" : "fal fa-expand", "link" : "#"},{"title":"Print page", "icon" : "fal fa-print", "link" : "#"},{"title":"Voice command", "icon" : "fal fa-microphone", "link" : "#"}] }';

        $colorJson='{ "colorList":[{"id":"myapp-0", "title" : "Wisteria (base css)"},{"id":"myapp-1", "theme" : "cust-theme-1.css", "title" : "Tapestry"},{"id":"myapp-2", "theme" : "cust-theme-2.css", "title" : "Atlantis"},{"id":"myapp-3", "theme" : "cust-theme-3.css", "title" : "Indigo"},{"id":"myapp-4", "theme" : "cust-theme-4.css", "title" : "Dodger Blue"},{"id":"myapp-5", "theme" : "cust-theme-5.css", "title" : "Tradewind"},{"id":"myapp-6", "theme" : "cust-theme-6.css", "title" : "Cranberry"},{"id":"myapp-7", "theme" : "cust-theme-7.css", "title" : "Oslo Gray"},{"id":"myapp-8", "theme" : "cust-theme-8.css", "title" : "Chetwode Blue"},{"id":"myapp-9", "theme" : "cust-theme-9.css", "title" : "Apricot"},{"id":"myapp-10", "theme" : "cust-theme-10.css", "title" : "Blue Smoke"},{"id":"myapp-11", "theme" : "cust-theme-11.css", "title" : "Green Smoke"},{"id":"myapp-12", "theme" : "cust-theme-12.css", "title" : "Wild Blue Yonder"},{"id":"myapp-13", "theme" : "cust-theme-13.css", "title" : "Emerald"}] }';

        $switchJson='{ "switchList":[{"id":"fh","dataClass" : "header-function-fixed","title" : "Fixed Header","desc" : "header is in a fixed at all times" },{"id":"nff","dataClass" : "nav-function-fixed","title" : "Fixed Navigation","desc" : "left panel is fixed" },{"id":"nff","dataClass" : "nav-function-minify","title" : "Minify Navigation","desc" : "Skew nav to maximize space" },{"id":"nfh","dataClass" : "nav-function-hidden","title" : "Hide Navigation","desc" : "roll mouse on edge to reveal" },   {"id":"nft","dataClass" : "nav-function-top","title" : "Top Navigation","desc" : "Relocate left pane to top" },{"id":"mmb","dataClass" : "mod-main-boxed","title" : "Boxed Layout","desc" : "Encapsulates to a container" }] }';

        return view('components.bottom-setting', compact('bottomMenuJson','colorJson','switchJson'));
    }
}
