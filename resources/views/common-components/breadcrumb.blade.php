 <ol class="breadcrumb page-breadcrumb">
     <li class="breadcrumb-item"><a href="javascript:void(0);">SmartAdmin</a></li>
     <li class="breadcrumb-item">{{ $item1 }}</li>
     @if(isset($item2))
     <li class="breadcrumb-item active">{{ $item2 }}</li>
     @endif
     @if(isset($item3))
     <li class="breadcrumb-item active">{{ $item3 }}</li>
     @endif
     <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
 </ol>