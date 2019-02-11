<html>
<head>
<style type="text/css">
table{ border-collapse: collapse; }
table.top{ width: 640px; margin: 25px auto; }
th{ font-size: 16px; text-align: left; }
.text-right{ text-align: right; }
.underline{ text-decoration: underline; }
.data-title{ font-size: 12px; padding: 5px 10px; }
.data-value{ font-size: 14px; padding: 5px 10px; }
.ed-header,
.emp-header,
.ref-header{ background: #303030; color: #efefef; }
.border{ border: solid 1px #303030; }
.border-top{ border-top: solid 1px #303030; }
.border-right{ border-right: solid 1px #303030; }
.border-bottom{ border-bottom: solid 1px #303030; }
.border-left{ border-left: solid 1px #303030; }
</style>
</head>
<body>
<table class="top">
	<tr>
		<th>Application For Employment</th>
	</tr>
	<tr>
		<td>
			<a href="$Submission.EditLink">View application online</a>.
		</td>
	</tr>
	<tr>
		<td>
			<a href="$Submission.Resume.AbsoluteLink">View resume online</a>.
		</td>
	</tr>
</table>

<!-- Personal Information -->
<table class="top">
	<tr>
		<td>
			<table width="100%">
				<tr>
					<th>Personal Information</th>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td class="border">
			<table width="100%">
				<tr>
					<td class="data-title">
						Name (Last Name First)
					</td>
				</tr>
				<tr>
					<td class="data-value">
						$Submission.LastName, $Submission.FirstName
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td class="border">
			<table width="100%">
				<tr>
					<td>
						<table width="100%">
							<tr>
								<td class="data-title">
									Email
								</td>
							</tr>
							<tr>
								<td class="data-value">
									$Submission.Email
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
    <tr>
        <td class="border">
            <table width="100%">
                <tr>
                    <td>
                        <table width="100%">
                            <tr>
                                <td class="data-title">
                                    Phone No.
                                </td>
                            </tr>
                            <tr>
                                <td class="data-value">
									$Submission.Phone
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<!-- Employment Desired -->
<table class="top">
	<tr>
		<th>Employment Desired</th>
	</tr>
	<tr>
		<td class="border">
			<table width="100%">
				<tr>
					<td class="data-title">
						Position
					</td>
				</tr>
				<tr>
					<td class="data-value">
						$Submission.Job.Title
					</td>
				</tr>
			</table>
		</td>
		<td class="border">
			<table width="100%">
				<tr>
					<td class="data-title">
						Date You Can Start
					</td>
				</tr>
				<tr>
					<td class="data-value">
						$Submission.Available
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>

<!-- Employment Desired -->
<table class="top">
    <tr>
		<th>Comments</th>
	</tr>
	<tr>
		<td class="border">
            <table width="100%">
                <tr>
                    <td class="data-value">
						$Submission.Content
                    </td>
                </tr>
            </table>
		</td>
	</tr>
</table>
</body>
</html>
