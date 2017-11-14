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
</table>

<!-- Personal Information -->
<table class="top">
	<tr>
		<td>
			<table width="100%">
				<tr>
					<th>Personal Information</th>
					<th class="text-right underline">Date: $Now.format(n/j/Y)</th>
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
						$LastName, $FirstName
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
									Present Address
								</td>
							</tr>
							<tr>
								<td class="data-value">
									$Address
								</td>
							</tr>
						</table>
					</td>
					<td class="border-left">
						<table width="100%">
							<tr>
								<td class="data-title">
									City
								</td>
							</tr>
							<tr>
								<td class="data-value">
									$City
								</td>
							</tr>
						</table>
					</td>
					<td class="border-left">
						<table width="100%">
							<tr>
								<td class="data-title">
									State
								</td>
							</tr>
							<tr>
								<td class="data-value">
									$State
								</td>
							</tr>
						</table>
					</td>
					<td class="border-left">
						<table width="100%">
							<tr>
								<td class="data-title">
									Zip Code
								</td>
							</tr>
							<tr>
								<td class="data-value">
									$PostalCode
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
									Permanent Address
								</td>
							</tr>
							<tr>
								<td class="data-value">
									$PAddress
								</td>
							</tr>
						</table>
					</td>
					<td class="border-left">
						<table width="100%">
							<tr>
								<td class="data-title">
									City
								</td>
							</tr>
							<tr>
								<td class="data-value">
									$PCity
								</td>
							</tr>
						</table>
					</td>
					<td class="border-left">
						<table width="100%">
							<tr>
								<td class="data-title">
									State
								</td>
							</tr>
							<tr>
								<td class="data-value">
									$PState
								</td>
							</tr>
						</table>
					</td>
					<td class="border-left">
						<table width="100%">
							<tr>
								<td class="data-title">
									Zip Code
								</td>
							</tr>
							<tr>
								<td class="data-value">
									$PPostalCode
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
									$Phone
								</td>
							</tr>
						</table>
					</td>
					<td class="border-left">
						<table width="100%">
							<tr>
								<td class="data-title">
									Referred By
								</td>
							</tr>
							<tr>
								<td class="data-value">
									$ReferredBy
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
						$Job.Title
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
						$Available
					</td>
				</tr>
			</table>
		</td>
		<td class="border">
			<table width="100%">
				<tr>
					<td class="data-title">
						Salary Desired
					</td>
				</tr>
				<tr>
					<td class="data-value">
						$Salary
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td class="border"<% if Employed = yes %> colspan="2"<% else %> colspan="3"<% end_if %>>
			<table width="100%">
				<tr>
					<td class="data-title">
						Are You Employed
					</td>
				</tr>
				<tr>
					<td class="data-value">
						$Employed
					</td>
				</tr>
			</table>
		</td>
		<% if $Employed = yes %>
		<td class="border">
			<table width="100%">
				<tr>
					<td class="data-title">
						May We Inquire Of Your Present Employer?
					</td>
				</tr>
				<tr>
					<td class="data-value">
						$InquireEmployer
					</td>
				</tr>
			</table>
		</td>
		<% end_if %>
	</tr>
	<tr>
		<td class="border">
			<table width="100%">
				<tr>
					<td class="data-title">
						Ever Applied To This Company Before?
					</td>
				</tr>
				<tr>
					<td class="data-value">
						$AppliedBefore
					</td>
				</tr>
			</table>
		</td>
		<% if $AppliedBefore %>
		<td class="border">
			<table width="100%">
				<tr>
					<td class="data-title">
						Where?
					</td>
				</tr>
				<tr>
					<td class="data-value">
						$AppliedWhere
					</td>
				</tr>
			</table>
		</td>
		<td class="border">
			<table width="100%">
				<tr>
					<td class="data-title">
						When?
					</td>
				</tr>
				<tr>
					<td class="data-value">
						$AppliedWhen
					</td>
				</tr>
			</table>
		</td>
		<% end_if %>
	</tr>
</table>

<!-- Education History -->
<table class="top">
	<tr>
		<th>Education History</th>
	</tr>
	<tr>
		<td>
			<table width="100%">
				<tr>
					<td colspan="2" class="ed-header">
						Name Of School
					</td>
					<td class="ed-header">
						Years Attended
					</td>
					<td class="ed-header">
						Did You Graduate?
					</td>
					<td class="ed-header">
						Subjects Studied
					</td>
				</tr>
				<tr>
					<td class="ed-level border-left">
						Grammar School
					</td>
					<td class="data-value border-left">
						$GName
					</td>
					<td class="data-value border-left">
						$GYears
					</td>
					<td class="data-value border-left">
						$GGrad
					</td>
					<td class="data-value border-top border-left border-right">
						$GSubjects
					</td>
				</tr>
				<tr>
					<td class="ed-level border-top border-left">
						High School
					</td>
					<td class="data-value border-top border-left">
						$HName
					</td>
					<td class="data-value border-top border-left">
						$HYears
					</td>
					<td class="data-value border-top border-left">
						$HGrad
					</td>
					<td class="data-value border-top border-left border-right">
						$HSubjects
					</td>
				</tr>
				<tr>
					<td class="ed-level border-top border-left">
						College
					</td>
					<td class="data-value border-top border-left">
						$CName
					</td>
					<td class="data-value border-top border-left">
						$CYears
					</td>
					<td class="data-value border-top border-left">
						$CGrad
					</td>
					<td class="data-value border-top border-left border-right">
						$CSubjects
					</td>
				</tr>
				<tr>
					<td class="ed-level border-top border-left border-bottom">
						Trade, Business Or Correspondence School
					</td>
					<td class="data-value border-top border-left border-bottom">
						$TName
					</td>
					<td class="data-value border-top border-left border-bottom">
						$TYears
					</td>
					<td class="data-value border-top border-left border-bottom">
						$TGrad
					</td>
					<td class="data-value border">
						$TSubjects
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>

<!-- General Information -->
<table class="top">
	<tr>
		<th>General Information</th>
	</tr>
	<tr>
		<td class="border">
			<table width="100%">
				<tr>
					<td class="data-title">
						Subjects Of Special Study/Research Work Or Special Training/Skills
					</td>
				</tr>
				<tr>
					<td class="data-value">
						$SpecialStudy
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
									U.S. Military Or Naval Service
								</td>
							</tr>
							<tr>
								<td class="data-value">
									$Military
								</td>
							</tr>
						</table>
					</td>
					<td class="border-left">
						<table width="100%">
							<tr>
								<td class="data-title">
									Rank
								</td>
							</tr>
							<tr>
								<td class="data-value">
									$Rank
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>

<!-- Former Employer -->
<table class="top">
	<tr>
		<th>Former Employer</th>
	</tr>
	<tr>
		<td>
			<table width="100%" class="border">
				<tr>
					<td class="emp-header">
						Date, Month and Year
					</td>
					<td class="emp-header">
						Name Of Employer
					</td>
					<td class="emp-header">
						Salary
					</td>
					<td class="emp-header">
						Position
					</td>
					<td class="emp-header">
						Reason For Leaving
					</td>
				</tr>
				<tr>
					<td class="border-bottom">
						<table width="100%">
							<tr>
								<td class="data-title border-bottom">
									From
								</td>
								<td class="data-value border-bottom">
									$E1From
								</td>
							</tr>
							<tr>
								<td class="data-title">
									To
								</td>
								<td class="data-value">
									$E1To
								</td>
							</tr>
						</table>
					</td>
					<td class="data-value border-left border-bottom">
						$E1Company
					</td>
					<td class="data-value border-left border-bottom">
						$E1Salary
					</td>
					<td class="data-value border-left border-bottom">
						$E1Position
					</td>
					<td class="data-value border-left border-bottom">
						$E1Leaving
					</td>
				</tr>
				<tr>
					<td class="border-bottom">
						<table width="100%">
							<tr>
								<td class="data-title border-bottom">
									From
								</td>
								<td class="data-value border-bottom">
									$E2From
								</td>
							</tr>
							<tr>
								<td class="data-title">
									To
								</td>
								<td class="data-value">
									$E2To
								</td>
							</tr>
						</table>
					</td>
					<td class="data-value border-left border-bottom">
						$E2Company
					</td>
					<td class="data-value border-left border-bottom">
						$E2Salary
					</td>
					<td class="data-value border-left border-bottom">
						$E2Position
					</td>
					<td class="data-value border-left border-bottom">
						$E2Leaving
					</td>
				</tr>
				<tr>
					<td class="border-bottom">
						<table width="100%">
							<tr>
								<td class="data-title border-bottom">
									From
								</td>
								<td class="data-value border-bottom">
									$E3From
								</td>
							</tr>
							<tr>
								<td class="data-title">
									To
								</td>
								<td class="data-value">
									$E3To
								</td>
							</tr>
						</table>
					</td>
					<td class="data-value border-left border-bottom">
						$E3Company
					</td>
					<td class="data-value border-left border-bottom">
						$E3Salary
					</td>
					<td class="data-value border-left border-bottom">
						$E3Position
					</td>
					<td class="data-value border-left border-bottom">
						$E3Leaving
					</td>
				</tr>
				<tr>
					<td>
						<table width="100%">
							<tr>
								<td class="data-title border-bottom">
									From
								</td>
								<td class="data-value border-bottom">
									$E4From
								</td>
							</tr>
							<tr>
								<td class="data-title">
									To
								</td>
								<td class="data-value">
									$E4To
								</td>
							</tr>
						</table>
					</td>
					<td class="data-value border-left">
						$E4Company
					</td>
					<td class="data-value border-left">
						$E4Salary
					</td>
					<td class="data-value border-left">
						$E4Position
					</td>
					<td class="data-value border-left">
						$E4Leaving
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>

<!-- References -->
<table class="top">
	<tr>
		<th>References</th>
	</tr>
	<tr>
		<td>
			<table width="100%" class="border">
				<tr>
					<td class="ref-header">
						Name
					</td>
					<td class="ref-header">
						Address
					</td>
					<td class="ref-header">
						Business
					</td>
					<td class="ref-header">
						Years Known
					</td>
				</tr>
				<tr>
					<td class="data-value border-bottom">
						$R1Name
					</td>
					<td class="data-value border-bottom border-left">
						$R1Address
					</td>
					<td class="data-value border-bottom border-left">
						$R1Business
					</td>
					<td class="data-value border-bottom border-left">
						$R1Years
					</td>
				</tr>
				<tr>
					<td class="data-value border-bottom">
						$R2Name
					</td>
					<td class="data-value border-bottom border-left">
						$R2Address
					</td>
					<td class="data-value border-bottom border-left">
						$R2Business
					</td>
					<td class="data-value border-bottom border-left">
						$R2Years
					</td>
				</tr>
				<tr>
					<td class="data-value">
						$R3Name
					</td>
					<td class="data-value border-left">
						$R3Address
					</td>
					<td class="data-value border-left">
						$R3Business
					</td>
					<td class="data-value border-left">
						$R3Years
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</body>
</html>
