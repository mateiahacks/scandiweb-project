import React, { Component } from "react";
import { connect } from "react-redux";
import { createOrder } from "../../state/actions/cartAction";
import CartWindowProduct from "./CartWindowProduct";
import "./CartWindowProduct.css";

class Cart extends Component {
  constructor(props) {
    super(props);
    this.state = {
      tax: 21,
    };
  }

  totalSum() {
    const cart = this.props.cart;
    const currs = this.props.currencies;
    const curr = this.props.currency;
    return cart
      .map((p) => p?.quantity * p?.prices[currs.indexOf(curr)]?.amount)
      .reduce((first, second) => first + second, 0);
  }

  onCheckout() {
    if (this.props.cart.length <= 0) {
      return;
    }
    const items = this.props.cart.map((item) => {
      return {
        product_id: item.id,
        quantity: item.quantity,
        attribute_ids: item.attributes.map(
          (a) => a.items.filter((e) => e.selected === true)[0].id
        ),
      };
    });

    this.props.createOrder(items);
  }

  render() {
    return (
      <div className="cart-window">
        <h3>My Bag, {this.props.totalQuantity} items</h3>
        <div className="window-products">
          {this.props.cart.map((p) => (
            <CartWindowProduct key={this.props.cart.indexOf(p)} product={p} />
          ))}
        </div>
        <div id="window-total">
          <h3>Total</h3>
          <h3 data-testid="cart-total">
            {this.props.currency.symbol} {this.totalSum().toFixed(2)}
          </h3>
        </div>
        <div className="window-buttons">
          <div
            id="checkout"
            className={this.props.cart.length === 0 ? "disabled" : ""}
            onClick={() => this.onCheckout()}
          >
            PLACE ORDER
          </div>
        </div>
      </div>
    );
  }
}

const mapStateToProps = (state) => ({
  cart: state.cartReducer.cart,
  totalQuantity: state.cartReducer.totalQuantity,
  currency: state.currencyReducer.currency,
  currencies: state.currencyReducer.currencies,
});

export default connect(mapStateToProps, { createOrder })(Cart);
