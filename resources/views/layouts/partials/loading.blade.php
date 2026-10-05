<div id="page-loader" class="loader-overlay loader-show">
    <div class="loader"></div>
</div>

<script>
    window.addEventListener('load', function() {
        const loaderOverlay = document.getElementById('page-loader');
        loaderOverlay.classList.remove('loader-show');

        document.addEventListener('submit', function() {
            loaderOverlay.classList.add('loader-show');
        });
    });
</script>

<style>
    .loader-overlay {
        position: fixed;
        inset: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 99999;
        pointer-events: none;
        transition: 0.3s ease;
        backdrop-filter: blur(4px);
        opacity: 0;
        visibility: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .loader-overlay.loader-show {
        pointer-events: auto;
        opacity: 1;
        visibility: visible;
    }

    .loader-overlay .loader {
        width: 50px;
        aspect-ratio: 1;
        display: grid;
        border: 4px solid #000;
        border-radius: 50%;
        border-color: #ccc transparent;
        animation: l16 1s infinite linear;
    }

    .loader-overlay .loader::before {
        content: "";
        grid-area: 1;
        margin: 2px;
        border: inherit;
        border-radius: 50%;
    }

    .loader-overlay .loader::before {
        border-color: #ccc transparent;
        animation: inherit;
        animation-duration: 0.5s;
        animation-direction: reverse;
    }

    .loader-overlay .loader::after {
        margin: 8px;
    }

    @keyframes l16 {
        100% {
            transform: rotate(1turn);
        }
    }
</style>
