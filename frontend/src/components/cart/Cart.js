import React, { Component } from "react";
import { connect } from "react-redux";
import { resetCart } from "../../state/actions/cartAction";
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
    const err_msg = document.getElementById("order-err");
    if (this.props.cart.length > 0) {
      this.props.resetCart();
      this.setState({ redirect: "/" });
      err_msg.style.display = "none";
    } else {
      err_msg.style.display = "block";
    }
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
          <h3>
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

export default connect(mapStateToProps, { resetCart })(Cart);
