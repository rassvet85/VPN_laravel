<?php

namespace App\View\Components;

use Illuminate\View\Component;

class header extends Component
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
        $headerMenuJson = '{ "quickShortcutJson":[{"title" : "Services","item1" : "base-2 icon-stack-3x color-primary-600","item2" : "base-3 icon-stack-2x color-primary-700", "item3" : "ni ni-settings icon-stack-1x text-white fs-lg" },{"title" : "Account", "item1" : "base-2 icon-stack-3x color-primary-400","item2" : "base-10 text-white icon-stack-1x", "item3" : "ni md-profile color-primary-800 icon-stack-2x"} ,{"title" : "Security", "item1" : "base-9 icon-stack-3x color-success-400","item2":"base-2 icon-stack-2x color-success-500", "item3" : "ni ni-shield icon-stack-1x text-white" },{ "isSpan" : "true","item1" : "base-18 icon-stack-3x color-info-700", "title" : "Calendar", "spanClass" : "position-absolute pos-top pos-left pos-right color-white fs-md mt-2 fw-400","spanText" : "28" },{"title" : "Stats","item1" : "base-7 icon-stack-3x color-info-500","item2" : "base-7 icon-stack-2x color-info-700", "item3" : "ni ni-graph icon-stack-1x text-white" },{"title" : "Messages","item1" : "base-4 icon-stack-3x color-danger-500","item2" : "base-4 icon-stack-1x color-danger-400", "item3" : "ni ni-envelope icon-stack-1x text-white" },{"title" : "Notes","item1" : "base-4 icon-stack-3x color-fusion-400","item2" : "base-5 icon-stack-2x color-fusion-200", "item3" : "fal fa-keyboard icon-stack-1x color-info-50" },{"title" : "Photos","item1" : "base-16 icon-stack-3x color-fusion-500","item2" : "base-10 icon-stack-1x color-primary-50 opacity-30", "item3" : "fal fa-dot-circle icon-stack-1x text-white opacity-85" },{"title" : "Maps","item1" : "base-19 icon-stack-3x color-primary-400","item2" : "base-7 icon-stack-1x fs-xxl color-primary-200", "item3" : "base-7 icon-stack-1x color-primary-500", "item4" : "fal fa-globe icon-stack-1x text-white opacity-85" },{"title" : "Chat","item1" : "base-5 icon-stack-3x color-success-700 opacity-80","item2" : "base-12 icon-stack-2x color-success-700 opacity-30", "item3" : "fal fa-comment-alt icon-stack-1x text-white" },{"title" : "Phone","item1" : "base-5 icon-stack-3x color-warning-600","item2" : "base-7 icon-stack-2x color-warning-800 opacity-50", "item3" : "fal fa-phone icon-stack-1x text-white" },{"title" : "Projects","item1" : "base-6 icon-stack-3x color-danger-600","item2" : "fal fa-chart-line icon-stack-1x text-white" }] }';

        $notificationMenuJson = '{ "notificationJson":[{"liClass" : "unread","avatar" : "/assets/img/demo/avatars/avatar-a.png","title" : "Adison Lee","desc" : "Msed quia non numquam eius","min":"2 minutes ago" },{"liClass" : "","avatar" : "/assets/img/demo/avatars/avatar-b.png","title" : "Oliver Kopyuv","desc" : "Msed quia non numquam eius","min":"3 minutes ago" },{"liClass" : "","avatar" : "/assets/img/demo/avatars/avatar-e.png","title" : "Dr. John Cook PhD","desc" : "Msed quia non numquam eius","min":"2 minutes ago" },{"liClass" : "","avatar" : "/assets/img/demo/avatars/avatar-h.png","title" : "Sarah McBrook","desc" : "Msed quia non numquam eius","min":"3 minutes ago" },{"liClass" : "","avatar" : "/assets/img/demo/avatars/avatar-m.png","title" : "Anothony Bezyeth","desc" : "Msed quia non numquam eius","min":"one minutes ago" },{"liClass" : "","avatar" : "/assets/img/demo/avatars/avatar-j.png","title" : "Lisa Hatchensen","desc" : "Msed quia non numquam eius","min":"one minutes ago" }] }';

        $profileJson='{ "profileList":[{"dataAction":"app-reset","i18n" : "drpdwn.reset_layout","title" : "Reset Layout" },{ "isModal" : "true", "dataTarget":".js-modal-settings","i18n" : "drpdwn.settings","title" : "Settings" },{ "isDivider" : "true" },{"dataAction":"app-fullscreen","i18n" : "drpdwn.fullscreen","title" : "Fullscreen", "iClass" : "float-right text-muted fw-n", "iText" : "F11" },{"dataAction":"app-print","i18n" : "drpdwn.print","title" : "Print", "iClass" : "float-right text-muted fw-n", "iText" : "Ctrl + P" }] }';

        return view('components.header', compact('headerMenuJson','notificationMenuJson','profileJson'));
    }
}
