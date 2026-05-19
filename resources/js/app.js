import "./bootstrap";

import "bootstrap";
import "bootstrap-icons/font/bootstrap-icons.css";

//plugins
import "./plugins/jquery";
import { initDataTables } from "./plugins/datatable";

// components
import "./components/sidebar";

//inicializar plugins
$(function () {
    initDataTables();
});
