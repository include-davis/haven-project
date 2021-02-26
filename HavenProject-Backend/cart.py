
from datetime import datetime
from flask import Flask, request, flash, url_for, redirect, render_template, jsonify
from flask_sqlalchemy import SQLAlchemy
from sqlalchemy.sql import func

merch = Flask(__name__)

merch.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False
merch.config['SQLALCHEMY_DATABASE_URI'] = 'sqlite:///db.sqlite3'
merch.config['SECRET_KEY'] = '_5#y2L"F4Q8z\n\xec]/'
db = SQLAlchemy(merch)


# an item
class Product(db.Model):
    name = db.Column(db.String(100), unique = True)
    img = db.Column(db.String(70), unique = True)
    price = db.Column(db.Float)

def __init__(self, name, img, price):
   self.name = name
   self.img = img
   self.price = price

# show what's in the cart
@merch.route('/cart')
def show_all():
    return render_template('', items = Product.query.all())


# add an item to cart
@merch.route('/add/<product_name>', methods=['POST'])
def add_to_cart(product_name):
    product = Product.query.filter(Product.name==product_name)
    db.session.add(product)
    db.session.commit()
    flash('Item was successfully added to cart')
    return redirect("")
    return render_template('')

# remove item from cart
@merch.route('/remove/<product_name>', methods = ['GET', 'POST'])
def delete(product_name):
    product = Product.query.filter(Product.name==product_name)
    if product is None:
        return f'Could not find product in cart'
    db.session.delete(product)
    db.session.commit()
    return redirect("")

# finds the total in the cart -> can be simplified to be written in SQL code
@merch.route('/total', methods = ['GET'])
def total():
    total = 0.00
    if Product.query.all() is None:
        return 0.00
    for item in Product.query.all():
        total = total + item.price
    return total
    
