# Warframechart
----------------------------
Live: https://warframchart.ct8.pl
**Basic backend functionality**:
- Data collection classes for item prices from https://warframe.market, and https://nexus-stats.com (cron_market_git.php, cron_chat_git.php).
- Static data collection from (wikiFetch.php):
  - http://warframe.wikia.com/wiki/Void_Relic/ByRelic
  - http://warframe.wikia.com/wiki/Void_Relic/ByRewards/SimpleTable ( ByRewads.php class)
  - http://warframe.wikia.com/wiki/Ducats/Prices
 - Store data in files:
   - resources/json/TYPE/ORDER_TYPE/ITEM/PLATFORM_graph.json (for market, and nexus)
   - resources/json/worldState/FILE.json

**Basic frontend explaination**
 - doubleList - array of items that need 2 parts of item;
 - Dialog - used to set basic Dialog (Modal);
 - CompChart - chart creation;
 - ValuesComparisment - the same value like in chart but in table;
 - Table - The core of the app, the table with all basic data;
 - App - Joins everything together, handles serialized $_GET vars;


**TODO**
 - Database (Doctrine ORM probably) + Entities for static item data and statistic data;
 - Autoupdate for frontend;
 - Adding chat lines to chart;
