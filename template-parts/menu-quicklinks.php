<nav id="quicklinks" aria-label="quick links" aria-hidden="true">
<?php
if ( UW_QuickLinks::template_menu() ):
    echo UW_QuickLinks::template_menu();
else: ?>
    <ul id="big-links">
        <li><span class="icon-myuw"></span><a href="https://my.uw.edu" tabindex=0">MyUW</a></li>
        <li><span class="icon-calendar"></span><a href="https://uw.edu/calendar/" tabindex="0">Calendar</a></li>
        <li><span class="icon-directories"></span><a href="https://uw.edu/directory/" tabindex="0">Directories</a></li>
        <li><span class="icon-libraries"></span><a href="https://lib.washington.edu" tabindex="0">Libraries</a></li>
        <li><span class="icon-medicine"></span><a href="https://uwmedicine.org" tabindex="0">UW Medicine</a></li>
        <li><span class="icon-maps"></span><a href="https://uw.edu/maps/" tabindex="0">Maps</a></li>
        <li><span class="icon-uwtoday"></span><a href="https://uw.edu/news/" tabindex="0">UW Today</a></li>
    </ul>

    <h3>Helpful Links</h3>
    <ul id="little-links">
        <li><span class="false"></span><a href="https://itconnect.uw.edu" tabindex="0">Computing/IT</a></li>
        <li><span class="false"></span><a href="https://isc.uw.edu/" tabindex="0">Employee Self Service</a></li>
        <li><span class="false"></span><a href="https://hfs.uw.edu/Husky-Card-Services/" tabindex="0">Husky Card</a></li>
        <li><span class="false"></span><a href="https://uwb.edu" tabindex="0">UW Bothell</a></li>
        <li><span class="false"></span><a href="https://tacoma.uw.edu" tabindex="0">UW Tacoma</a></li>
        <li><span class="false"></span><a href="https://facebook.com/UofWA" tabindex="0">UW Facebook</a></li>
        <li><span class="false"></span><a href="https://twitter.com/UW" tabindex="0">UW Twitter</a></li>
    </ul>
<?php endif; ?>
</nav>
