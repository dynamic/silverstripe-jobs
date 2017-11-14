<ul class="collapse divider divider-repeat">
    <% if $Tags %>
    <li class="label">TAG:</li>
	    <% loop $Tags %>
	    	<li><a href="{$Link}">$Title</a></li>
	    <% end_loop %>
	<% end_if %>
   <%-- <li class="label">TYPE:</li>
    <li><a href="{$Parent.Link}type/$PositionType/">$PositionType</a></li>
    <% if Posted %>
    	<li class="label">POSTED:</li>
    	<li>$Posted</li>
    <% end_if %> --%>
</ul>