<div style="text-align: left !important; width: 200px; display: block;">
	<p style="margin-bottom: 0px;">Layanan {{ env('APP_NAME','THUNDER cust') }}</p>
</div>
<div class="clearfix">&nbsp;</div>
<div class="clearfix" style="border-bottom: 1px solid #d8d8d8">&nbsp;</div>
<div class="clearfix">&nbsp;</div>
<table class="w-100 text-color font-small font-light" style="text-align: left !important;">
	<tbody>
		<tr>
			<td class="text-left">
				© {{ now()->format('Y') }} {{ env('APP_NAME','THUNDER cust') }}  |  {{ env('APP_URL','https://thunderlab.id') }}
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>
				Untuk informasi lebih lanjut, silahkan hubungi Layanan {{ env('APP_NAME','THUNDER cust') }} melalui <strong><a name="email" style="color: inherit;">{{ env('APP_MAIL') }}</a></strong>
			</td>
		</tr>
	</tbody>
</table>