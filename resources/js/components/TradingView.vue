<template>
  <div :id="container_id" style="margin-bottom: 40px"></div>
</template>

<script>
const SCRIPT_ID = "tradingview-widget-script";
const CONTAINER_ID = "trading-view";

export default {
  name: "TradingView",
  data() {
    return {
      options: {
        colorTheme: "dark",
        dateRange: "12M",
        showChart: true,
        locale: this.$root.$i18n.locale == "en" ? "en" : "zh_CN",
        largeChartUrl: "",
        isTransparent: true,
        showSymbolLogo: true,
        width: "100%",
        height: "660",
        plotLineColorGrowing: "rgba(33, 150, 243, 1)",
        plotLineColorFalling: "rgba(33, 150, 243, 1)",
        gridLineColor: "rgba(240, 243, 250, 1)",
        scaleFontColor: "rgba(120, 123, 134, 1)",
        belowLineFillColorGrowing: "rgba(33, 150, 243, 0.12)",
        belowLineFillColorFalling: "rgba(33, 150, 243, 0.12)",
        symbolActiveColor: "rgba(33, 150, 243, 0.12)",
        tabs: [
          {
            title: "Indices",
            symbols: [
              {
                s: "FOREXCOM:SPXUSD",
                d: "S&P 500",
              },
              {
                s: "FOREXCOM:NSXUSD",
                d: "Nasdaq 100",
              },
              {
                s: "FOREXCOM:DJI",
                d: "Dow 30",
              },
              {
                s: "INDEX:NKY",
                d: "Nikkei 225",
              },
              {
                s: "INDEX:DEU30",
                d: "DAX Index",
              },
              {
                s: "FOREXCOM:UKXGBP",
                d: "FTSE 100",
              },
            ],
            originalTitle: "Indices",
          },
          {
            title: "Commodities",
            symbols: [
              {
                s: "CME_MINI:ES1!",
                d: "S&P 500",
              },
              {
                s: "CME:6E1!",
                d: "Euro",
              },
              {
                s: "COMEX:GC1!",
                d: "Gold",
              },
              {
                s: "NYMEX:CL1!",
                d: "Crude Oil",
              },
              {
                s: "NYMEX:NG1!",
                d: "Natural Gas",
              },
              {
                s: "CBOT:ZC1!",
                d: "Corn",
              },
            ],
            originalTitle: "Commodities",
          },
          {
            title: "Bonds",
            symbols: [
              {
                s: "CME:GE1!",
                d: "Eurodollar",
              },
              {
                s: "CBOT:ZB1!",
                d: "T-Bond",
              },
              {
                s: "CBOT:UB1!",
                d: "Ultra T-Bond",
              },
              {
                s: "EUREX:FGBL1!",
                d: "Euro Bund",
              },
              {
                s: "EUREX:FBTP1!",
                d: "Euro BTP",
              },
              {
                s: "EUREX:FGBM1!",
                d: "Euro BOBL",
              },
            ],
            originalTitle: "Bonds",
          },
          {
            title: "Forex",
            symbols: [
              {
                s: "FX:EURUSD",
              },
              {
                s: "FX:GBPUSD",
              },
              {
                s: "FX:USDJPY",
              },
              {
                s: "FX:USDCHF",
              },
              {
                s: "FX:AUDUSD",
              },
              {
                s: "FX:USDCAD",
              },
            ],
            originalTitle: "Forex",
          },
        ],
      },
      container_id: CONTAINER_ID,
    };
  },
  methods: {
    canUseDOM() {
      return (
        typeof window !== "undefined" &&
        window.document &&
        window.document.createElement
      );
    },
    getScriptElement() {
      return document.getElementById(SCRIPT_ID);
    },
    updateOnloadListener(onload) {
      const script = this.getScriptElement();
      const oldOnload = script.onload;
      return (script.onload = () => {
        oldOnload();
        onload();
      });
    },
    scriptExists() {
      return this.getScriptElement() !== null;
    },
    appendScript(onload) {
      if (!this.canUseDOM()) {
        onload();
        return;
      }

      if (this.scriptExists()) {
        if (typeof TradingView === "undefined") {
          this.updateOnloadListener(onload);
          return;
        }
        onload();
        return;
      }
      const script = document.createElement("script");
      script.id = SCRIPT_ID;
      script.type = "text/javascript";
      script.async = true;
      script.text = JSON.stringify(this.options);
      script.src =
        "https://s3.tradingview.com/external-embedding/embed-widget-market-overview.js";
      script.onload = onload;
      document.getElementById(this.container_id).appendChild(script);
    },
    initWidget() {
      if (typeof TradingView === "undefined") {
        return;
      }

      new window.TradingView.widget(
        Object.assign({ container_id: this.container_id })
      );
    },
  },
  mounted() {
    this.appendScript(this.initWidget);
  },
};
</script>
