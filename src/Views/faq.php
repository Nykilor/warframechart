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
                <li><b>item</b></li>
                <li><b>min</b>, <b>max</b>, <b>avg</b>, <b>median</b>, <b>mode</b></li>
                <li><b>ducat</b></li>
                <li><b>player</b> name</li>
                <li><b>drop</b> place</li>
                <li><b>type</b> of item (primary, secondary etc.)</li>
              </ul>
              Example: player=Nykilor|item=Akbolto<br />
              Simply: COLUMN=VALUE|COLUMN=VALUE
            </p>
            <h4>Pro Tips:</h4>
            <ul>
              <li>If you sort by ITEM the items will group up and the script will sum up the set/part values.</li>
              <li>Save some typing, type "lith: v1 v2" to search for "lith v1" and "lith v2". <b>Notes: there can not be a space at the end.</b></li>
              <li>Use the builder to make a quick check during or before run.</li>
              <li><u>Use the <span class="icon-share"> SHARE URL to share your ordered search result with friends.</u></li>
              <li>You don't have to click on the search bar, just start typing.</li>
              <li>You can look for only vaulted by typing 'is_vaulted' or other way around 'not_vaulted'</li>
            </ul>
          </div>
          <h3 class="icon-download">LOADING</h3>
          <div class="sub-text">
            <h4 class="icon-chart-line">Values Graph</h4>
            <p>Loads ChartJS library. Now if you click item name you'll load a modal with a chart of values. Defaulty it is limited to 7 days and 24 nodes per day, you can change that by clicking the gear top left of it.</p>
            <h4 class="icon-terminal">Chat Data</h4>
            <p>Extends each row in table with the chat values from https://nexus-stats.com/.</p>
          </div>
          <h3 class="icon-eye-off">Filters</h3>
          <div class="sub-text">
          <h4 class="icon-table">Columns</h4>
              <p>Show/Hide column.</p>
              <h4 class="icon-globe">Stat. Values</h4>
              <p>Use GLOBAL or VARIABLES based stat. values.</p>
              <p>GLOBAL - Dosn't matter from which platform.</p>
              <p>VARIABLES - The value will be based depending on the platform chosen and ignored players, ignoring players will affect every aspect of the table.</p>
              <h4 class="icon-calculator">Calculate values based on</h4>
              <p>Here you select from what values should the calculations of ratio, set-parts value and other to come be based on.</p>
              <h4 class="icon-desktop">Platform</h4>
              <p>The little counter next to cart defines how many orders are there for this item at platform "PC", "PS4", "XB1/XBOX". If you use this option while having PLATFORM based stats the value's will change depending on the platform.</p>
              <h4 class="icon-basket">Order type</h4>
              <p>Depending on what you're looking. Sell is for sell orders, buy is for buy orders.</p>
          </div>
          <h3 class="icon-wifi">Offline</h3>
          <div class="sub-text">
            <p>The website is a PWA (Progressive Web App), that means that you can browse it while offline (With limited functionality) after you load in on your device at least once.</p>
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
              <p>If you use the "GLOBAL" option the min, avg and median will be the global values, it means that it does not matter if it's PC/PS4/XB1 price. If you wan't a lowest for your platform consider switching to the "VARIABLES" option.</p>
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
