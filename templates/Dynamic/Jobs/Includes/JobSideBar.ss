<aside>
	<% if $Tags %>
	    <%-- include TagList --%>
	<% end_if %>

    <% if $JobTypeList %>
        <h3>Types</h3>
        <ul>
            <% loop $JobTypeList %>
            <li><a href="{$Top.Link}type/$Type/">$Type</a> ($JobCount)</li>
            <% end_loop %>
        </ul>
    <% end_if %>
</aside>
