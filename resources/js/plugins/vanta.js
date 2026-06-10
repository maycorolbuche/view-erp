import * as THREE from "three";
import NET from "vanta/dist/vanta.net.min";

let vantaEffect = null;

(() => {
    "use strict";

    function initVanta() {
        const hero = document.querySelector(".vanta-three");

        if (!hero) return;

        hero.innerHTML = "";

        if (vantaEffect) {
            vantaEffect.destroy();
        }

        vantaEffect = NET({
            el: hero,
            THREE,
            mouseControls: true,
            touchControls: true,
            gyroControls: false,
            minHeight: 200,
            minWidth: 200,
            scale: 1,
            scaleMobile: 1,
            color: 0x3d0000,
            backgroundColor: 0x000000,
        });
    }

    document.addEventListener("DOMContentLoaded", () => {
        initVanta();
    });
})();
