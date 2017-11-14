<div class="content-container">
	<article>
		<h1>$Title</h1>

		<% include Dynamic\Jobs\JobDetail %>

		<h3>Application Received</h3>

    	<% if $Parent.Message %>
    		$Parent.Message
    	<% else %>
    		<p>Thank you for your application.</p>
    	<% end_if %>

   </article>
</div>
<% with $Parent %>
<% include Dynamic\Jobs\JobSideBar %>
<% end_with %>
