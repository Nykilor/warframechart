<body>
    <noscript>
        <p>Not a fan of JS? Check this out: <a href="nojs/sell.html">printable/no-js version</a></p>
    </noscript>
    <dialog class="faq-help" id="faq">
        <div class="container">
          <button type="button" name="tour" id="introJS" class="btn-gradient">Tour me!</button>
            <div class="help">
                <h1>Help</h1>
                <p>
                  <b>Notice:</b> All values that use some kind of timestamp or time are converted to your timezone :)
                </p>
                <div class="sub-text">
                    <h3 class="icon-search">Searching</h3>
                    <div class="sub-text">
                      <p>Use the search bar to look up for items by name, value, drop location, player or type, you can either type single or multiple names. Regex should work too.</p>
                      <p>You can search by names or relics like: "oberon|ash" or "axi c1|ash|axi c2"</p>
                      <p>Or by specific column:
                        <ul>
                          <li>item</li>
                          <li>min, max, avg, median, mode</li>
                          <li>ducat valuer / ratio</li>
                          <li>player name</li>
                          <li>drop place</li>
                          <li>type of item (primary, secondary etc.)</li>
                        </ul>
                        Example: player=Nykilor|item=Akbolto<br />
                        Simply: COLUMN=VALUE|COLUMN=VALUE
                      </p>
                      <h4>Pro Tips:</h4>
                      <p>If you sort by ITEM the items will group up and the script will sum up the set/part values.</p>
                      <p>Save some typing, type "lith: v1 v2" to search for "lith v1" and "lith v2". Notes: there can not be a space at the end.</p>
                      <p>Use the builder to make a quick check during or before run.</p>
                      <p><u>Use the <span class="icon-share"> SHARE URL to share your ordered search result with friends.</u></p>
                      <p>You don't have to click on the search bar, just start typing.</p>
                      <p>You can look for only vaulted by typing 'is_vaulted' or other way around 'not_vaulted'</p>
                    </div>
                    <h3 class="icon-download">LOADING</h3>
                    <div class="sub-text">
                      <h4 class="icon-chart-line">Values Graph</h4>
                      <p>Load ChartJS library and now if you click items name you'll load a modal with a chart of values. Defaulty it is limited to 7 days and 6 nodes per day, you can change that by clicking the gear top left of it.</p>
                      <h4 class="icon-table">Values Table</h4>
                      <p>Will add a table to the modal with the values visible on the graph itself.</p>
                      <h4 class="icon-terminal">Chat Data</h4>
                      <p>Extends each row in table with the chat values.</p>
                    </div>
                    <h3 class="icon-eye-off">Filters</h3>
                    <div class="sub-text">
                    <h4 class="icon-table">Columns</h4>
                        <p>Show/Hide column.</p>
                        <h4 class="icon-globe">Stat. Values</h4>
                        <p>Use GLOBAL or PLATFORM / PLAYERS based stat. values.</p>
                        <p>GLOBAL - Dosn't matter from which platform.</p>
                        <p>PLATFORM / PLAYERS - The value will be based depending on the platform chosen and ignored players, ignoring players will affect every aspect of the table.</p>
                        <h4 class="icon-calculator">Calculate values based on</h4>
                        <p>Here you select from what values should the calculations of ratio, set-parts value and other to come be based on.</p>
                        <h4 class="icon-desktop">Platform</h4>
                        <p>The little counter next to cart defines how many orders are there for this item at platform "PC", "PS4", "XB1/XBOX". If you use this option while having PLATFORM based stats the value's will change depending on the platform.</p>
                        <h4 class="icon-basket">Order type</h4>
                        <p>Depending on what you're looking. Sell is for sell orders, buy is for buy orders.</p>
                    </div>
                    <h3 class="icon-wifi">Offline</h3>
                    <div class="sub-text">
                      <p>The website is a PWA (Progressive Web App), that means that you can browse it while offline (With limited functionality).</p>
                    </div>
                    <h3 class="icon-plus">Icons and shorts</h3>
                    <div class="sub-text">
                      <h4>Icons</h4>
                      <ul>
                          <li class="icon-basket"> - 'go shoping' (opens the sellers list).</li>
                          <li class="icon-star"> - not favourite.</li>
                          <li class="icon-star-filled" style="color: palevioletred;"> - is your favourite.</li>
                          <li class="icon-star-filled" style="background-color: #fdc9da;"> - in your favourite item group.</li>
                          <li class="icon-desktop"> - that the value is 'warframe.market' based.</li>
                          <li class="icon-terminal"> - this value is 'nexus-stats.com' based.</li>
                      </ul>
                      <h4>Shorts</h4>
                      <ul>
                          <li><small class="save success-save"><span class="icon-desktop">32 S</span></small> - read it as '<b>S</b>ave <b>32</b> platinium by buying/selling <b>S</b>et by using <b>warframe.market</b>', click to sort by it.</li>
                          <li><small class="save fail-save"><span class="icon-desktop">1 P</span></small> - read it as '<b>L</b>ose <b>1</b> platinium by buying/selling <b>P</b>artialy by using <b>warframe.market</b>', click to sort by it.</li>
                      </ul>
                    </div>
                    <h3 class="icon-cursor">Shortcuts</h3>
                    <div class="sub-text">
                      <p>&#8592; and &#8594; arrow on your keyboard to change page.</p>
                    </div>
                </div>
                <hr>
                <h1 class="icon-ok">FAQ</h1>
                <div class="sub-text">
                    <h3>Why's the min 60, but the lowest order 80?</h3>
                        <p>If you use the "GLOBAL" option the min, avg and median will be the global values, it means that it does not matter if it's PC/PS4/XB1 price. If you wan't a lowest for your platform consider switching to the "PLATFORM" option.</p>
                    <h3>What's the delay between the calls?</h3>
                        <p>30 mins, where the collection should take from 3 - 15 mins. It's for now 900+ calls, 3 calls per item; 1 call per platform.</p>
                    <h3>How do you get the data?</h3>
                        <p>I use the API of those sites:
                          <ul>
                            <li><a href="https://warframe.market">Warframe.market</a> - Market (Most precise)</li>
                            <li><a href="https://nexus-stats.com/">Nexus-stats</a> - Chat (OCR collected, less precise)</li>
                          </ul>
                        </p>
                    <h3>Why this site's so ugly?</h3>
                        <p>Well I do work on making it pretty.</p>
                    <h3>Hey can you add "this, that" to the listing?</h3>
                        <p>Sure just use the <a href="https://www.reddit.com/message/compose/?to=nykilor&subject=Add%20to%20chart" target="_blank" rel="noopener"><button type="button" name="request" class="menu-btn icon-plus">ADD ITEM</button></a> button and pm me on reddit.</p>
                    <h3>Can i somehow help you?</h3>
                        <p><a href="https://github.com/Nykilor/warframechart">*HERE SHOULD BE A GITHUB LINK*</a> you can help me optimize this, or just <a href="http://paypal.me/AMigacz" target="_blank" rel="noopener">donate</a> a few $ for better hosting and a coffee for me.</p>
                    <h3>This site is to heavy for my PC/PHONE/POTATO to handle, is there any other option?</h3>
                        <p>Click here <a href="nojs/sell.html" title="nojs" class="menu-btn" target="_blank">NO&nbsp;JS/PRINT</a>, there you'll find just the most basic values.</p>
                    <h3>What are you now planing?</h3>
                        <p>My TODO list looks sort of like this:</p>
                        <ul>
                          <li>A normal hosting, to transfer the data from files into a database (the free hosting got it's limitations).</li>
                          <li>Full automatization in data collection; A unvault? A new prime? The site updates by itself as soon as the new data is avilable on the wiki.</li>
                          <li>Domain.</li>
                        </ul>
                </div>
            </div>
            <button type="button" name="close-btn" class="dialog-close icon-cancel-1">Close</button>
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
  <div>
    <div class="open-menu-absolute">
      <button name="menu-open" class="open-menu icon-menu">
      </button>
    </div>
    <header class="meta-header clearfix">
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
                    <div class="row" data-step="14" data-intro="If this is checked you'll open a modal with a table of how the values for the item you clicked changed overtime.">
                        <label>
                            <input type="checkbox" name="Table" value="true" id="ValuesComparisment" hidden>
                            <div class="text icon-table">Values Table</div>
                        </label>
                    </div>
                    <div class="row" data-step="15" data-intro="If this is checked there will be an additional row of chat values for each item.">
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
          <li><a href="https://www.reddit.com/message/compose/?to=nykilor&subject=Add%20to%20chart" target="_blank" rel="noopener"><button type="button" name="request" class="menu-btn icon-plus" data-step="16" data-intro="Click this to send me PM on reddit about adding an item to the table.">ADD ITEM</button></a></li>
          <li><button type="button" name="help" id="faq-help-open" class="menu-btn icon-help">Help\FAQ</button></li>
          <li><button type="button" name="relic-run" id="build-relic-run" class="menu-btn icon-hammer" class="intro-wraper" data-step="17" data-intro="Use this if you do a relic run, here you can quickly check the value of items.">RELIC RUN</button></li>
          <li><button type="button" name="get-link" id="get-link" class="menu-btn icon-get-link" data-step="19" data-intro="Share your settings with friends in game so they can check for themselfs the values. (The url will force all your settings on them rewriting their own.)">SHARE</button><textarea class="share-copy-area"></textarea></li>
          <li><a href="nojs/sellpc.html" title="nojs" target="_blank"><button type="button" name="request" class="menu-btn icon-print" data-step="18" data-intro="Simple HTML table with no JS at all.">NO JS</button></a></li>
        </ul>
      </nav>
      <hr class="divide">
      <div class="header-part right center-mobile">
          <time>
              <b>Update:<br></b> <span id="last-update"></span>
          </time>
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
              <div title="Table will be based on values from players with the platform picked from below.">PLATFORM / PLAYERS</div>
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
