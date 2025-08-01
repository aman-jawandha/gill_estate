<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Gill Estate</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif;">
  <table width="100%" cellpadding="0" cellspacing="0" border="0">
    <tr>
      <td align="center">
        <table width="600" cellpadding="0" cellspacing="0" border="0">
          <tr>
            <td width="35%" align="right" valign="middle" style="padding: 10px;">
              <img src="{{ url('assets/img/core-img/logo.png') }}" alt="Logo" width="100" style="display: block;">
            </td>
            <td width="75%" align="left" valign="middle" style="padding: 10px;">
              <h1 style="margin: 0; font-size: 20px; color: #7176bf;">Gill Estate</h1>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
<h2>{{ $details['title'] }}</h2>
<p>
    {!! $details['body'] !!}<br>
    Thanks and regards,<br>
    Gill Estate Team
</p>
</body>
</html>