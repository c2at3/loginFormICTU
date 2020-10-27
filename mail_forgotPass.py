import smtplib, ssl, sys
from email.mime.text import MIMEText
from email.mime.multipart import MIMEMultipart
import base64

sender_email = "atttk16@gmail.com"
receiver_email = sys.argv[1]
password = ""

message = MIMEMultipart("alternative")
message["Subject"] = "["+sys.argv[2]+"] Request to change password"
message["From"] = sender_email
message["To"] = receiver_email

# Create the plain-text and HTML version of your message
text = """\
Hi,"""+sys.argv[2]+"""
"""
html = """
<html>
  <body>
    <p>Hi,"""+sys.argv[2]+"""<br>
        You have requested to change your password, click <a href='"""+base64.b64decode(sys.argv[3]).decode()+"""'>Change password</a> to continue.
        If this is not a request from you, please <a href="http://localhost/ATW_Login/loginForm.php">protect your account more</a><br>Thanks!
    </p>
  </body>
</html>
"""

# Turn these into plain/html MIMEText objects
part1 = MIMEText(text, "plain")
part2 = MIMEText(html, "html")

# Add HTML/plain-text parts to MIMEMultipart message
# The email client will try to render the last part first
message.attach(part1)
message.attach(part2)

# Create secure connection with server and send email
context = ssl.create_default_context()
with smtplib.SMTP_SSL("smtp.gmail.com", 465, context=context) as server:
    server.login(sender_email, password)
    server.sendmail(
        sender_email, receiver_email, message.as_string()
    )
