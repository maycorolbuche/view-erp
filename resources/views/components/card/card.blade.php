 <div class="card {{ $fullHeight ? 'h-100' : '' }}">
     <div class="card-body">
         @if (!empty($title))
             <div class="card-title">
                 @if (!empty($icon))
                     <span class="card-icon">
                         <i class="{{ $icon }}"></i>
                     </span>
                 @endif
                 {{ $title }}
             </div>
         @endif
         <p class="card-text">
             @if (empty($title) && !empty($icon))
                 <span class="card-icon">
                     <i class="{{ $icon }}"></i>
                 </span>
             @endif
             {{ $slot }}
         </p>
     </div>
 </div>
