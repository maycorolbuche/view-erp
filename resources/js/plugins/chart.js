import Highcharts from "highcharts";
import "highcharts/modules/accessibility";
import "highcharts/modules/no-data-to-display";

const instances = new WeakMap();

export function initCharts(root = document) {
    root.querySelectorAll("[data-chart]").forEach((element) => {
        if (instances.has(element)) return;

        try {
            const type = element.dataset.chartType || "pie";
            const series = JSON.parse(element.dataset.chartSeries || "[]");
            const categories = JSON.parse(element.dataset.chartCategories || "[]");
            const name = element.dataset.chartSeriesName;
            const theme = getComputedStyle(element);
            const color = theme.getPropertyValue("--bs-body-color").trim() || "#212529";
            const border = theme.getPropertyValue("--bs-border-color").trim() || "#dee2e6";
            const colors = ["warning", "primary", "info", "danger", "success", "secondary"]
                .map((key) => theme.getPropertyValue(`--bs-${key}`).trim())
                .filter(Boolean);

            const chart = Highcharts.chart(element, {
                credits: { enabled: false },
                chart: { type, backgroundColor: "transparent", style: { fontFamily: "inherit" } },
                title: { text: null },
                lang: { decimalPoint: ",", thousandsSep: ".", noData: "Sem dados para exibir" },
                ...(colors.length ? { colors } : {}),
                tooltip: { pointFormat: element.dataset.chartPointFormat },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: "pointer",
                        dataLabels: { enabled: false },
                        showInLegend: true,
                    },
                    column: { stacking: "normal" },
                },
                legend: { itemStyle: { color }, itemHoverStyle: { color } },
                noData: { style: { color } },
                xAxis: { categories, labels: { style: { color } }, lineColor: border, tickColor: border },
                yAxis: {
                    allowDecimals: false,
                    min: 0,
                    title: { text: name, style: { color } },
                    labels: { style: { color } },
                    gridLineColor: border,
                },
                series: type === "column" ? series : [{ type, name, data: series }],
            });

            instances.set(element, chart);
        } catch (error) {
            console.error("Não foi possível inicializar o gráfico", element.id, error);
        }
    });
}

if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", () => initCharts(), { once: true });
} else {
    initCharts();
}
