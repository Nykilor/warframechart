<body>
    <noscript>
        <p>Not a fan of JS? Check this out: <a href="nojs/sell.html">printable/no-js version</a></p>
    </noscript>
    <dialog class="faq-help" id="faq">
        <div class="container">
          <?php
          require("faq.php");
          ?>
        </div>
    </dialog>
    <dialog class="relic-run" id="relic-run">
      <div class="container">
        <div class="relics">
          <label class="relics-label">
            <input type="radio" class="set-relic" name="column" value="Lith" hidden>
            <div class="relics-bg lith-bg">LITH</div>
          </label>
          <label class="relics-label">
            <input type="radio" class="set-relic" name="column" value="Meso" hidden>
            <div class="relics-bg meso-bg">MESO</div>
          </label>
          <label class="relics-label">
            <input type="radio" class="set-relic" name="column" value="Neo" hidden>
            <div class="relics-bg neo-bg">NEO</div>
          </label>
          <label class="relics-label">
            <input type="radio" class="set-relic" name="column" value="Axi" hidden>
            <div class="relics-bg axi-bg">AXI</div>
          </label>
        </div>
        <div class="clearfix"></div>
        <div class="types">

        </div>
        <button type="button" name="search" class="build-relic-btn dialog-close">SHOW ME THIS</button>
      </div>
    </dialog>
    <dialog id="chart-dialog">
      <div class="container">
        <div class="loading-indicator">
          <div class="sk-cube-grid">
            <div class="sk-cube sk-cube1"></div>
            <div class="sk-cube sk-cube2"></div>
            <div class="sk-cube sk-cube3"></div>
            <div class="sk-cube sk-cube4"></div>
            <div class="sk-cube sk-cube5"></div>
            <div class="sk-cube sk-cube6"></div>
            <div class="sk-cube sk-cube7"></div>
            <div class="sk-cube sk-cube8"></div>
            <div class="sk-cube sk-cube9"></div>
          </div>
        </div>
        <h2 id="chart-title"></h2>
        <details class="graph-options details-options">
          <summary title="Days: 7, Nodes: 8"><span class="icon-cog"></span></summary>
          <div class="filters flex-column">
            <div class="icon-sun-filled informative-icons">
              <input type="number" class="graph-number-input" name="daysBack" id="chartDaysBack" value="" min="1" max="365" step="7" placeholder="Days back on graph: " list="daysBackList">
              <datalist id="daysBackList">
                <option value="3">
                <option value="7">
                <option value="14">
                <option value="21">
                <option value="30">
                <option value="45">
                <option value="60">
                <option value="90">
              </datalist>
            </div>
            <div class="icon-dot-2 informative-icons">
              <input type="number" class="graph-number-input" name="maxNodesPerDay" id="chartMaxNodesPerDay" min="2" max="24" step="2" placeholder="Max node per day: " list="maxNodesPerDayList">
              <datalist id="maxNodesPerDayList">
                <option value="2">
                <option value="6">
                <option value="12">
                <option value="16">
                <option value="24">
              </datalist>
            </div>
            <hr>
            <p>Animations: <input type="checkbox" name="animations" value="true" id="chartAnimations" checked></p>
          </div>
        </details>
        <div class="chart" style="display: none;">
          <canvas id="chart" style="width: 100%; min-height: 50vh;"></canvas>
        </div>
        <div class="values-comparisment" style="display: none;">
          <details class="details-options">
            <summary><span class="icon-cog"></span></summary>
            <div class="filters" style="width: max-content;">
              <label class="filter-label">
                <input type="checkbox" class="filter-input show-column-comparisment" name="column" value="1" hidden>
                <div>MIN</div>
              </label>
              <label class="filter-label">
                <input type="checkbox" class="filter-input show-column-comparisment" name="column" value="2" hidden>
                <div>AVG</div>
              </label>
              <label class="filter-label">
                <input type="checkbox" class="filter-input show-column-comparisment" name="column" value="3" hidden>
                <div>MED</div>
              </label>
              <label class="filter-label">
                <input type="checkbox" class="filter-input show-column-comparisment" name="column" value="4" hidden>
                <div>MODE</div>
              </label>
            </div>
          </details>
          <table id="valuesTable">
            <thead>
              <th>DATE</th>
              <th>MIN</th>
              <th>AVG</th>
              <th>MED</th>
              <th>MODE</th>
            </thead>
            <tbody>

            </tbody>
            <tfoot>

            </tfoot>
          </table>
        </div>
      </div>
    </dialog>
    <dialog class="ignored-list" id="ignored-list">
        <div class="container">

        </div>
    </dialog>
  <div>
    <div class="open-menu-absolute">
      <button name="menu-open" class="open-menu icon-menu">
      </button>
    </div>
    <header class="meta-header clearfix">
      <div class="menu-content-container">
        <div class="close-menu-container">
          <button type="button" name="menu-close" class="icon-cancel-1 close-menu"></button>
        </div>
        <hr class="divide">
        <nav class="header-part left center-mobile">
          <ul>
            <li>
              <details class="details-drop">
                  <summary class="icon-download" data-step="12" data-intro="Here you can set the data you want to load.">LOADING</summary>
                  <div class="dropdown-container">
                      <b>Load:</b>
                      <div class="row" data-step="13" data-intro="If this is checked you'll open a modal with a chart of how the values for the item you clicked changed overtime.">
                          <label>
                              <input type="checkbox" name="Table" value="true" id="CompChart" hidden>
                              <div class="text icon-chart-line">Values Graph</div>
                          </label>
                      </div>
                      <div class="row" data-step="14" data-intro="If this is checked there will be an additional row of chat values for each item.">
                          <label>
                              <input type="checkbox" name="Table" value="true" id="ChatData" hidden>
                              <div class="text icon-terminal">Chat Data</div>
                          </label>
                      </div>
                      <div class="row">
                          <label>
                              <input type="checkbox" name="PrimaryData" value="true" hidden checked disabled>
                              <div class="text icon-desktop">Market Data</div>
                          </label>
                      </div>

                  </div>
              </details>
            </li>
            <li><a href="https://www.reddit.com/message/compose/?to=nykilor&subject=Add%20to%20chart" target="_blank" rel="noopener"><button type="button" name="request" class="menu-btn icon-plus" data-step="15" data-intro="Click this to send me PM on reddit about adding an item to the table.">ADD ITEM</button></a></li>
            <li><button type="button" name="help" id="faq-help-open" class="menu-btn icon-help">Help\FAQ</button></li>
            <li><button type="button" name="relic-run" id="build-relic-run" class="menu-btn icon-hammer" class="intro-wraper" data-step="17" data-intro="Use this if you do a relic run, here you can quickly check the value of items.">RELIC RUN</button></li>
            <li><button type="button" name="get-link" id="get-link" class="menu-btn icon-get-link" data-step="19" data-intro="Share your settings with friends in game so they can check for themselfs the values. (The url will force all your settings on them rewriting their own.)">SHARE</button><textarea class="share-copy-area"></textarea></li>
            <li><button type="button" name="help" id="ignored-open" class="menu-btn icon-eye">Ignored List</button></li>
            <li><a href="nojs/sellpc.html" title="nojs" target="_blank"><button type="button" name="request" class="menu-btn icon-print" data-step="18" data-intro="Simple HTML table with no JS at all.">NO JS</button></a></li>
          </ul>
        </nav>
        <hr class="divide">
        <div class="header-part right center-mobile">
            <time>
                <b>Update:<br></b> <span id="last-update"></span>
            </time>
        </div>
      </div>
    </header>
    <main>
      <div class="search-bar">
        <label>
          <input type="search" autocomplete="off" id="search" placeholder="What do you need Tenno?" aria-controls="dataTable" data-step="7" data-intro="Use the bar to search for things that you're interested in. You don't have to click it, you can start typing right away. You can search by name or relict, you can look up for multiple like 'Saryn|Vauban|lith v3'.">
          <span class="icon-star-filled" id="show-fav" data-step="11" data-intro="Click this button to search for your favourite items/groups."></span>
        </label>
      </div>
      <details class="filters-details" data-step="1" data-intro="You can set your table here.">
        <summary class="table-summary icon-cog">TABLE FILTERS / OPTIONS</summary>
        <div class="filters">
          <div class="intro-wraper" data-step="2" data-intro="Here you can change the visibility of the columns.">
            <h3 class="icon-table">COLUMNS: </h3>
            <div class="flex flex-row flex-wrap-center">
              <label class="filter-label">
                <input type="checkbox" class="filter-input show-column" name="column" value="1" hidden>
                <div>MIN</div>
              </label>
              <label class="filter-label">
                <input type="checkbox" class="filter-input show-column" name="column" value="2" hidden>
                <div>AVG</div>
              </label>
              <label class="filter-label">
                <input type="checkbox" class="filter-input show-column" name="column" value="3" hidden>
                <div>MED</div>
              </label>
              <label class="filter-label">
                <input type="checkbox" class="filter-input show-column" name="column" value="4" hidden>
                <div>MODE</div>
              </label>
              <label class="filter-label">
                <input type="checkbox" class="filter-input show-column" name="column" value="5" hidden>
                <div>DUCATS</div>
              </label>
              <label class="filter-label">
                <input type="checkbox" class="filter-input show-column" name="column" value="6" hidden>
                <div>RATIO</div>
              </label>
              <label class="filter-label">
                <input type="checkbox" class="filter-input show-column" name="column" value="7" hidden>
                <div>ACTION</div>
              </label>
              <label class="filter-label">
                <input type="checkbox" class="filter-input show-column" name="column" value="8" hidden>
                <div>RELICT</div>
              </label>
            </div>
          </div>
          <div class="intro-wraper" data-step="3" data-intro="Here you can set from what column should be the DUCAT : PLATINUM ratio, if it's better to buy parts or set, and any other calculatiosn to come.">
            <h3 class="icon-calculator">CALCULATE VALUES BASED ON:</h3>
            <label for="filter-label flex flex-row">
              <label class="filter-label">
                <input type="radio" class="filter-input ratio-calc" name="ratio" value="min" hidden>
                <div>MIN</div>
              </label>
              <label class="filter-label">
                <input type="radio" class="filter-input ratio-calc" name="ratio" value="avg" hidden>
                <div>AVG</div>
              </label>
              <label class="filter-label">
                <input type="radio" class="filter-input ratio-calc" name="ratio" value="median" hidden>
                <div>MED</div>
              </label>
              <label class="filter-label">
                <input type="radio" class="filter-input ratio-calc" name="ratio" value="mode" hidden>
                <div>MODE</div>
              </label>
            </label>
          </div>
          <div class="intro-wraper" data-step="4" data-intro="Set if the values ought be platform based, or global (PC,PS4,XB1). E.g. The min price on Saryn Prime Set is 30 on PC and 40 on PS4, if you want a platform based value while having PS4 platform set you'll see 40; but if you use the global you'll see 30.">
            <h3 class="icon-globe">STAT. VALUES(EN): </h3>
            <label class="filter-label">
              <input type="radio" class="filter-input value-type" name="values" value="0" hidden checked>
              <div title="Values will be based on global ones.">GLOBAL</div>
            </label>
            <label class="filter-label" id="order-based">
              <input type="radio" class="filter-input value-type" name="values" value="1" hidden>
              <div title="Table will be based on values from orders depending on the platform of choice.">VARIABLES</div>
            </label>
          </div>
          <div class="intro-wraper" data-step="5" data-intro="Select the platform you're interested in, it will affect the STAT. VALUES and the number next to the <span class='icon-basket'></span>">
            <div class="platform-wraper">
              <h3 class="icon-desktop">PLATFORM: </h3>
              <label class="filter-label">
                <input type="radio" class="filter-input platform" name="platform" value="pc" hidden checked>
                <div>PC</div>
              </label>
              <label class="filter-label">
                <input type="radio" class="filter-input platform" name="platform" value="ps4" hidden>
                <div>PS4</div>
              </label>
              <label class="filter-label">
                <input type="radio" class="filter-input platform" name="platform" value="xbox" hidden>
                <div>XB1</div>
              </label>
            </div>
          </div>
          <div class="intro-wraper" data-step="6" data-intro="Transit between SELL and BUY orders.">
            <h3 class="icon-basket">ORDER TYPE: </h3>
            <label class="filter-label">
              <input type="radio" class="filter-input data-type" name="dataType" value="sell" hidden checked>
              <div>SELL</div>
            </label>
            <label class="filter-label">
              <input type="radio" class="filter-input data-type" name="dataType" value="buy" hidden>
              <div>BUY</div>
            </label>
          </div>
        </div>
      </details>
      <div class="container-for-table-comparisment">
          <div class="table-wrapper">
              <table id="dataTable" width="100%">
                <thead data-step="8" data-intro="Click on any of the column headers to order the table by it. If you order by 'ITEM' that will create groups and the script will sum if you should buy/sell parts or whole sets.">
                  <tr>
                    <th>ITEM</th>
                    <th>MIN</th>
                    <th>AVG</th>
                    <th>MED</th>
                    <th>MODE</th>
                    <th><img src="img/ducats.png" alt="ducats" width="20" height="20" class="icon-vert-middle"><span class="hidden">DUCATS</span></th>
                    <th><img src="img/ducats.png" alt="ducats" width="20" height="20" class="icon-vert-middle"> : <img src="img/PlatinumLarge.png" alt="plat" width="20" height="20" class="icon-vert-middle"></th>
                    <th></th>
                    <th>DROP</th>
                  </tr>
                </thead>
                <tbody>

                </tbody>
                <tfoot>

                </tfoot>
              </table>
          </div>
      </div>
    </main>
  </div>
  <script type="text/javascript">
  <?php
    $index = new WChart\Controller\Js($_GET);
    $index->printJSVar();
   ?>
  </script>
  <script type="module" src="js/Bundle.js"></script>
  <script type="text/javascript">
  if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('sw.js').then(() => {
      console.log('Service Worker registered successfully.');
    }).catch(error => {
      console.log('Service Worker registration failed:', error);
    });
  }
  </script>
</body>

</html>
