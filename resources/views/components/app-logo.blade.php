@props(['class' => 'h-12 w-12'])

<svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg" {{ $attributes->merge(['class' => $class]) }}>
    <!-- Background Circle -->
    <circle cx="100" cy="100" r="90" fill="url(#gradient)" />
    
    <!-- Gradient Definition -->
    <defs>
        <linearGradient id="gradient" x1="0%" y1="0%" x2="100%" y2="100%">
            <stop offset="0%" style="stop-color:#0ea5e9;stop-opacity:1" />
            <stop offset="100%" style="stop-color:#a855f7;stop-opacity:1" />
        </linearGradient>
    </defs>
    
    <!-- Book Icon -->
    <g transform="translate(50, 60)">
        <!-- Book Pages -->
        <rect x="10" y="0" width="80" height="70" rx="5" fill="white" opacity="0.9" />
        <rect x="15" y="5" width="70" height="60" rx="3" fill="white" />
        
        <!-- Book Spine -->
        <rect x="48" y="0" width="4" height="70" fill="#0ea5e9" opacity="0.3" />
        
        <!-- AI Brain Symbol -->
        <circle cx="50" cy="35" r="15" fill="none" stroke="#a855f7" stroke-width="3" />
        <circle cx="45" cy="32" r="2" fill="#a855f7" />
        <circle cx="55" cy="32" r="2" fill="#a855f7" />
        <path d="M 45 40 Q 50 43 55 40" stroke="#a855f7" stroke-width="2" fill="none" />
    </g>
    
    <!-- Decorative Stars -->
    <circle cx="150" cy="50" r="3" fill="white" opacity="0.8" />
    <circle cx="160" cy="70" r="2" fill="white" opacity="0.6" />
    <circle cx="40" cy="60" r="2.5" fill="white" opacity="0.7" />
</svg>
