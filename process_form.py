#!/usr/bin/env python3
import cgi
import smtplib
import re
from email.mime.text import MIMEText
from email.utils import formatdate

def validate_input(data):
    errors = {}
    
    # Name validation
    if not re.match(r'^[A-Za-z ]{3,50}$', data.getvalue('name', '')):
        errors['name'] = 'Invalid name format (3-50 letters and spaces)'
    
    # Email validation
    if not re.match(r'^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$', 
                    data.getvalue('email', '')):
        errors['email'] = 'Invalid email address'
    
    # Phone validation
    if not re.match(r'^\(\d{3}\) \d{3}-\d{4}$', data.getvalue('phone', '')):
        errors['phone'] = 'Invalid phone format (###) ###-####'
    
    # Message validation
    message = data.getvalue('message', '')
    if len(message) < 10 or len(message) > 1000:
        errors['message'] = 'Message must be 10-1000 characters'
    
    # Company sanitization
    company = data.getvalue('company', '')
    if len(company) > 100:
        errors['company'] = 'Company name too long'
    
    return errors, {
        'name': data.getvalue('name').strip(),
        'email': data.getvalue('email').strip(),
        'phone': data.getvalue('phone').strip(),
        'company': company[:100].strip(),
        'message': message.strip()
    }

def send_email(data):
    msg = MIMEText(f"""
    New Contact Form Submission:
    Name: {data['name']}
    Email: {data['email']}
    Phone: {data['phone']}
    Company: {data['company']}
    Message: {data['message']}
    """)
    
    msg['Subject'] = 'New Contact Form Submission'
    msg['From'] = 'webmaster@ecotechsolutions.com'
    msg['To'] = 'info@ecotechsolutions.com'
    msg['Date'] = formatdate(localtime=True)
    
    try:
        with smtplib.SMTP('localhost') as server:
            server.send_message(msg)
        return True
    except Exception as e:
        print(f"Error sending email: {str(e)}")
        return False

def show_error_page(errors):
    print("Content-type: text/html\n")
    print("""
    <html>
    <head><title>Form Errors</title></head>
    <body>
        <h1>Form Validation Errors</h1>
        <ul>""")
    for field, error in errors.items():
        print(f"<li>{field}: {error}</li>")
    print("""</ul>
        <a href="/contact.php">Go back to form</a>
    </body>
    </html>""")

def main():
    form = cgi.FieldStorage()
    errors, clean_data = validate_input(form)
    
    if errors:
        show_error_page(errors)
        return
    
    if send_email(clean_data):
        print("Content-type: text/html\n")
        print("""
        <html>
        <head><title>Thank You</title></head>
        <body>
            <h1>Thank you for your message!</h1>
            <p>We'll respond within 24 business hours.</p>
            <a href="/">Return to Homepage</a>
        </body>
        </html>""")
    else:
        print("Status: 500 Internal Server Error\n")
        print("Content-type: text/html\n")
        print("<h1>Error processing your request. Please try again later.</h1>")

if __name__ == "__main__":
    main()