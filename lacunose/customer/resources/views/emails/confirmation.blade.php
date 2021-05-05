<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	@include('tcust::emails.style')
</head>
<body>
	<table class="container">
		<tbody>
			<tr>
				<td>
					<div class="clearfix">&nbsp;</div>
					<div class="responsive-body">
						<div class="content"> 
							<p>Hello <strong>{{ $name }}</strong></p>
							<p>{!! $description !!}</p>
							<h2 style="text-align: center; background: grey; padding: 10px;">{!!$token!!}</h2>
							<div class="clearfix">&nbsp;</div>
							<div class="clearfix">&nbsp;</div>
							@include('tcust::emails.footer')
						</div>
					</div>
				</td>
			</tr>
		</tbody>
	</table>
</body>
</html>