from flask import Flask, render_template, redirect, url_for, request, json, session
from faker import Faker
import datetime
import requests

app = Flask(__name__)
app.config['SECRET_KEY'] = '1234567890'

import os

API_TOKEN = os.getenv('API_TOKEN') or 'b8323ea1b53a4cb3b2c8f0163fa159cd'
API_URL = os.getenv('API_URL') or 'https://checkoutapi-demo.bill24.net'


@app.route('/')
def index():
    return redirect(url_for('order_confirm'))


@app.route('/order/confirm', methods=['GET'])
def order_confirm():
    fake = Faker()
    return render_template(
        'order/confirm.html',
        order_code=str(fake.ssn()).replace('-', ''),
        order_date=datetime.datetime.now(),
        customer_name=fake.name(),
        amount=5,
        description='Checkout from e-commerce website.',
        api_token=API_TOKEN,
        action_url=url_for('checkout')
    )


@app.route('/checkout', methods=['POST'])
def checkout():
    form = request.form
    token = form['api_token']
    session['token'] = token

    url = '%s//transaction/init' % API_URL
    headers = {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'token': token
    }
    payload = {
        'reference_id': form['order_code'],
        'amount': form['amount'],
        'currency': form['currency'],
        'description': form['description'],
        'confirm_url': url_for('checkout_success', _external=True),
        'cancel_url': url_for('checkout_fail', _external=True)
    }
    response = requests.post(url=url, headers=headers, json=payload, verify=False)
    response_body = json.loads(response.content)

    if response.status_code == 200:
        # redirect to payment page
        payment_url = response_body['data']['payment_url']
        return redirect(payment_url)
    else:
        return json.dumps(response_body)


@app.route('/checkout/success', methods=['GET'])
def checkout_success():
    data = request.args.to_dict(flat=True)
    code = data.get('code')
    message = data.get('message')

    if code == 'SUCCESS':
        tran = json.loads(data.get('data'))
        return render_template(
            'checkout/success.html',
            tran=tran
        )
    else:
        return render_template(
            'checkout/fail.html',
            error_code=code,
            error_message=message
        )


@app.route('/checkout/fail', methods=['GET'])
def checkout_fail():
    data = request.args.to_dict(flat=True)
    error_code = '0000'
    error_message = 'Error'
    return render_template(
        'checkout/fail.html',
        error_code=error_code,
        error_message=error_message
    )


if __name__ == '__main__':
    app.run('127.0.0.1', 6001, threaded=True)
