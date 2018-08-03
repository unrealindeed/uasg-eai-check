# -*- coding: utf-8 -*-

import sys
import dns.resolver
import smtplib


def error_paragraph(error):
    print('<p style="color: #cf111d;">%s</p>' % (error, ))


def test_server(addressToVerify):
    splitAddress = addressToVerify.split('@')
    domain = splitAddress[1]

    domain = domain.decode('utf-8')
    domain = domain.encode('idna')

    try:
        records = dns.resolver.query(domain, 'MX')
    except:
        error_paragraph("No MX records found for domain.")
        return
    mxRecord = records[0].exchange
    mxRecord = str(mxRecord)

    try:
        smtp = smtplib.SMTP(mxRecord)
    except:
        error_paragraph("Unable to connect to mail server.")
        return

    smtp.ehlo_or_helo_if_needed()
    if not smtp.has_extn('SMTPUTF8'):
        error_paragraph("EAI support not declared by server.")
        return
    error = False
    resp = smtp.docmd('mail from:<ﻡﺮﺤﺑﺍﺍﻷﺮﺿ@भारतसरकार.भारत>', 'SMTPUTF8')
    if resp[0] != 250:
        error = True
        error_paragraph("<strong>Unicode</strong> not supported.")

    smtp.docmd('rset')

    resp = smtp.docmd('mail from:<ﻡﺮﺤﺑﺍﺍﻷﺮﺿ@xn--11b3a0ambb7c4bf.xn--h2brj9c>', 'SMTPUTF8')
    if resp[0] != 250:
        error = True
        error_paragraph("<strong>Unicode@punycode</strong> not supported.</p>")

    smtp.docmd('rset')

    resp = smtp.docmd('mail from:<=?UTF-8?B?2YXYsdit2KjYp9in2YTYo9ix2LY=?=@xn--11b3a0ambb7c4bf.xn--h2brj9c>', 'SMTPUTF8')
    if resp[0] != 250:
        error = True
        error_paragraph("<strong>ACE</strong> not supported.")

    if not error:
        print '<p style="color: #15a358;"><strong>EAI</strong> is supported!</p>'

email = sys.argv[1]
test_server(email)
#test_server('kōrero@ngāpukapuka.nz')
#test_server('niall@blacknight.com')
#test_server('niall@áras.ie')
