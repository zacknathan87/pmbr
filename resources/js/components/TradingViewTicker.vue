<template>
  <div :id="container_id" style="margin-bottom: 20px"></div>
</template>

<script>
const SCRIPT_ID = "tradingview-widget-script2";
const CONTAINER_ID = "trading-view2";

export default {
  name: "TradingView",
  data() {
    return {
      options: {
        symbols: [
          {
            proName: "FOREXCOM:SPXUSD",
            title: "S&P 500",
          },
          {
            proName: "FOREXCOM:NSXUSD",
            title: "Nasdaq 100",
          },
          {
            proName: "FX_IDC:EURUSD",
            title: "EUR/USD",
          },
          {
            proName: "BITSTAMP:BTCUSD",
            title: "BTC/USD",
          },
          {
            proName: "BITSTAMP:ETHUSD",
            title: "ETH/USD",
          },
        ],
        showSymbolLogo: true,
        colorTheme: "dark",
        isTransparent: true,
        displayMode: "adaptive",
        locale: "en",
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
        "https://s3.tradingview.com/external-embedding/embed-widget-ticker-tape.js";
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
