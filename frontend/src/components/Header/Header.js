import React, { Component } from "react";
import { MdKeyboardArrowDown } from "react-icons/md";
import { BsCart2 } from "react-icons/bs";
import { Link } from "react-router-dom";
import { connect } from "react-redux";
import { setCategory } from "../../state/actions/categoryAction";
import {
  setCurrency,
  fetchCurrencies,
} from "../../state/actions/currencyAction";
import { resetCart } from "../../state/actions/cartAction";
import logo from "../../images/logo.png";
import "./Header.css";
import "../Cart/CartWindowProduct.css";
import Cart from "../Cart/Cart";

class Header extends Component {
  constructor(props) {
    super(props);

    this.state = {
      showCart: false,
    };
  }

  toggleCurrencies() {
    const el = document.getElementById("currs");
    el.style.display === "block"
      ? (el.style.display = "none")
      : (el.style.display = "block");
  }

  componentDidMount() {
    window.addEventListener("mouseup", (event) => {
      const el = document.getElementById("currs");
      if (event.target !== el && event.target.parentNode !== el) {
        el.style.display = "none";
      }
    });
  }

  totalSum() {
    const cart = this.props.cart;
    const currs = this.props.currencies;
    const curr = this.props.currency;
    return cart
      .map((p) => p.quantity * p.prices[currs.indexOf(curr)].amount)
      .reduce((first, second) => first + second, 0);
  }

  selectCategory(cat) {
    this.props.setCategory(cat.name);
  }

  onCheckout() {
    if (this.props.cart.length === 0) {
      return;
    }
    this.setState({ showCart: false });
    this.props.resetCart();
    this.setState({ redirect: "/" });
  }

  render() {
    return (
      <div>
        <div className="header" id="header">
          {this.state.showCart && <Cart />}
          <div className="header__left">
            {this.props.categories?.map((c) => (
              <Link to="/" className="text-link" key={c.name}>
                <div
                  onClick={() => this.selectCategory(c)}
                  className={
                    c.name === this.props.currentCategory
                      ? "category category-selected"
                      : "category"
                  }
                >
                  {c.name?.toUpperCase()}
                </div>
              </Link>
            ))}
          </div>

          <Link to="/">
            <img src={logo} alt="logo" id="logo"></img>
          </Link>
          <div className="header__right flex-centered">
            <div
              className="currency flex-centered"
              onClick={this.toggleCurrencies}
            >
              <p id="curr-symbol">{this.props.currency.symbol}</p>
              <p>
                <MdKeyboardArrowDown size={15} />
              </p>
              <ul id="currs">
                {this.props.currencies.map((e) => (
                  <li key={e.label} onClick={() => this.props.setCurrency(e)}>
                    {e.symbol} {e.label}
                  </li>
                ))}
              </ul>
            </div>
            <div
              className="cart"
              onClick={() => this.setState({ showCart: !this.state.showCart })}
            >
              <BsCart2 id="cart-icon" size={25} />
              {this.props.totalQuantity !== 0 && (
                <div className="cart-num">{this.props.totalQuantity}</div>
              )}
            </div>
          </div>
        </div>
        {this.state.showCart && (
          <div
            className="bg"
            onClick={() => this.setState({ showCart: false })}
          ></div>
        )}
      </div>
    );
  }
}

const mapStateToProps = (state) => ({
  currentCategory: state.categoryReducer.category,
  categories: state.categoryReducer.categories,
  currencies: state.currencyReducer.currencies,
  currency: state.currencyReducer.currency,
  cart: state.cartReducer.cart,
  totalQuantity: state.cartReducer.totalQuantity,
});

const mapDispatchToProps = {
  setCategory,
  setCurrency,
  fetchCurrencies,
  resetCart,
};

export default connect(mapStateToProps, mapDispatchToProps)(Header);
