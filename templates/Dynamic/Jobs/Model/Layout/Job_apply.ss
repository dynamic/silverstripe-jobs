<div class="content-container">
	<article>
		<h1>$Title</h1>

		<% include Dynamic\Jobs\JobDetail %>

		<h3 class="detail-subhead">Apply Online</h3>

		<p>Please complete the form below to apply for this position.</p>

		$Form

	</article>
</div>
<% with $Parent %>
<% include Dynamic\Jobs\JobSideBar %>
<% end_with %>
