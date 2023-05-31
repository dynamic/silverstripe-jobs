<% if $Title || $Content %>
    <div class="col-md-12">
    <% if $Title && $ShowTitle %><h2 class="element__title">$Title</h2><% end_if %>
    <% if $Content %><div class="element__content">$Content</div><% end_if %>
    </div>
<% end_if %>

<% if $PostsList %>
    <div class="col-md 12 open-positions mb-1">
        <% loop $PostsList %>
            <div class="open-positions__position $EvenOdd" data-aos="fade-up" data-aos-orig="fade-up"<% if $First %>style="border-top: none" <% end_if %>>
                <div class="open-positions__summary">
                    <h3><a href="$Link" title="Get more information about $Title">$Title</a></h3>
                    <h4><i class="fas fa-user"></i> $PositionType<% if $Categories %> <span class="spacer">|</span> <i class="fas fa-tag"></i> <% loop $Categories %>$Title<% if not $Last %>, <% end_if %><% end_loop %><% end_if %></h4>
                    $Content.FirstParagraph
                </div>
                <div class="open-positions__buttons">
                    <a href="$ApplyButton" class="btn btn-primary btn-gradient" title="Apply for $Title">Apply</a>
                    <a href="$Link" class="btn btn-outline-primary" title="Get more information about $Title">More Info</a>
                </div>
            </div>
        <% end_loop %>
    </div>
<% end_if %>
