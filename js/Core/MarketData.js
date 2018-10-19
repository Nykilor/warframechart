let MarketData = {
  getBase(dataType) {
    return $.getJSON("json/current_market_" + dataType + ".json");
  },
  getItemRangeData(dataType, id, platform, end, start) {
    return $.getJSON("api/data/chart/market?type=" + dataType + "&id=" + id + "&platform=" + platform + "&end=" + end + "&start=" + start);
  }
};
export default MarketData;
