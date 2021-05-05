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
							@if($url)
							<h2 style="text-align: center; background: #15c; padding: 10px;">
								<a href="{!!$url!!}" style="color: #fff">Klik Disini</a>
							</h2>
							@endif
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