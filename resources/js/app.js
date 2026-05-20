import "./bootstrap";

import "bootstrap";
import "bootstrap-icons/font/bootstrap-icons.css";

//plugins
import { initDataTables } from "./plugins/datatable";
import { initTomSelect } from "./plugins/tom-select";

// components
import "./components/sidebar";

//inicializar plugins
$(function () {
    initDataTables();
    initTomSelect();
});
