<nav id="quicklinks" aria-label="quick links" aria-hidden="true">
<?php
if ( UW_QuickLinks::template_menu() ):
    echo UW_QuickLinks::template_menu();
else: ?>
    <ul id="big-links">
        <li><span class="icon-myuw" tabindex="-1"></span><a href="https://my.uw.edu">MyUW</a></li>
        <li><span class="icon-calendar" tabindex="-1"></span><a href="https://uw.edu/calendar/">Calendar</a></li>
        <li><span class="icon-directories" tabindex="-1"></span><a href="https://uw.edu/directory/">Directories</a></li>
        <li><span class="icon-libraries" tabindex="-1"></span><a href="https://lib.washington.edu">Libraries</a></li>
        <li><span class="icon-medicine" tabindex="-1"></span><a href="https://uwmedicine.org">UW Medicine</a></li>
        <li><span class="icon-maps" tabindex="-1"></span><a href="https://uw.edu/maps/">Maps</a></li>
        <li><span class="icon-uwtoday" tabindex="-1"></span><a href="https://uw.edu/news/">UW Today</a></li>
    </ul>

    <h3>Helpful Links</h3>
    <ul id="little-links">
        <li><span class="false" tabindex="-1"></span><a href="https://itconnect.uw.edu">Computing/IT</a></li>
        <li><span class="false" tabindex="-1"></span><a href="https://isc.uw.edu/">Employee Self Service</a></li>
        <li><span class="false" tabindex="-1"></span><a href="https://hfs.uw.edu/Husky-Card-Services/">Husky Card</a></li>
        <li><span class="false" tabindex="-1"></span><a href="https://uwb.edu">UW Bothell</a></li>
        <li><span class="false" tabindex="-1"></span><a href="https://tacoma.uw.edu">UW Tacoma</a></li>
        <li><span class="false" tabindex="-1"></span><a href="https://facebook.com/UofWA">UW Facebook</a></li>
        <li><span class="false" tabindex="-1"></span><a href="https://twitter.com/UW">UW Twitter</a></li>
    </ul>
<?php endif; ?>
</nav>
