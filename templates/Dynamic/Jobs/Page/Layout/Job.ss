<div class="row">
	$Breadcrumbs
</div>
<div class="twelve columns alpha">
	<h2>$Title</h2>

	<article>
		<% if $Image %><p class="half-bottom">$Image.LargePadded(600,400)</p><% end_if %>
		<% if $SubTitle %><h3>$SubTitle</h3><% end_if %>

		<div class="toolbar">
			<%-- TODO - include ShareThis --%>
		</div>
        <a href="$ApplyButton">Apply</a>
		<div class="content typography">$Content</div>

		<% if $SlideShow %>
			<div class="slideshow clearfix">
				<% include FlexSlider %>
			</div>
		<% end_if %>

		<% if $Tags %><p><% include Dynamic\Jobs\JobCategories %></p><% end_if %>

	</article>

	$Form
	$PageComments

</div>
<div class="four columns sidebar omega">
	<aside>
		<% include SideBar %>
	</aside>
</div>
