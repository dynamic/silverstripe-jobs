<div class="row">
	$Breadcrumbs
</div>
<div class="twelve columns alpha typography">
	<article>
		<h2>$Title</h2>
		<% if $SubTitle %><h3>$SubTitle</h3><% end_if %>
		<div class="content typography">$Content</div>
	</article>

	<% if $Message %><h4>$Message</h4><% end_if %>

	<% if $PaginatedList %>
		<% loop $PaginatedList %>
			<section class="row $EvenOdd clearfix">
				<% include Dynamic\Jobs\JobSummary %>
			</section>
		<% end_loop %>

		<% with $PaginatedList %>
			<% include Pagination %>
		<% end_with %>
	<% else %>
		<p>No entries</p>
	<% end_if %>
</div>
<div class="four columns sidebar omega">
	<aside>
		<%-- include RssLink %>
		<% include TagList --%>
	</aside>
</div>
