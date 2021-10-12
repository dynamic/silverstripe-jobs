<div class="col-sm-6">
    <div class="home-news-events">
        <% if $PostsList %>
            <div class="overlay"></div>
            <div class="news-events-label"><span>$Title</span></div>

            <% loop $PostsList %>
                <% if $PreviewImage %>
                    <img class="lazy scale-with-grid" src="$PreviewImage.Fill(555,555).URL" alt="<% if $Headline %>$Headline<% else %>$Name<% end_if %> Thumbnail">
                <% else_if $Image %>
                    <img class="lazy scale-with-grid" src="$Image.Fill(555,555).URL" alt="<% if $Headline %>$Headline<% else %>$Name<% end_if %> Thumbnail">
                <% else %>
                    <img class="lazy scale-with-grid" src="$ThemeDir/images/default/Spiff-Default-Blog-Image.jpg" alt="$Title Thumbnail">
                <% end_if %>


                <div class="text-overlay">
                    <div class="inner">
                        <h3 class="NewsHeader"><a href="$Link.ATT" title="Go to the $Title post">$Title</a></h3>
                        <p><a href="$Link" class="btn ghost" title="Continue reading about $Title">Read More</a></p>
                    </div>
                </div>
            <% end_loop %>
        <% end_if %>

    </div>
</div>
