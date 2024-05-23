import React, { Component } from "react";
import { connect } from "react-redux";
import {
  increase,
  decrease,
  setQuantity,
} from "../../state/actions/cartAction";
import "./CartWindowProduct.css";
import { toKebabCase } from "../../utils/helpers.js";

class CartWindowItem extends Component {
  constructor(props) {
    super(props);
    this.state = {
      quantity: this.props.product.quantity,
    };
  }

  render() {
    const { product, currency, currencies } = this.props;

    return (
      <div className="window-product">
        <div className="window-info">
          <p>{product.brand}</p>
          <p>{product.name}</p>
          <h3>
            {currency.symbol}{" "}
            {product.prices[currencies.indexOf(currency)].amount.toFixed(2)}
          </h3>
          <div className="window-attributes">
            {product.attributes.map((a) => (
              <div
                key={a.id}
                className="window-attribute"
                data-testid={`cart-item-attribute-${toKebabCase(a.name)}`}
              >
                <p>{a.name}:</p>
                <div className="window-items">
                  {a.items.map((i) => (
                    <div
                      data-testid={`cart-item-attribute-${toKebabCase(
                        a.name
                      )}-${toKebabCase(i.value)}${
                        i.selected ? "-selected" : ""
                      }`}
                      key={i.id}
                      style={{
                        background: a.type === "swatch" ? i.value : "",
                        border:
                          i.displayValue === "White" ? "1px solid black" : "",
                      }}
                      className={
                        a.type === "swatch"
                          ? i.selected
                            ? "window-item-swatch swatch-selected"
                            : "window-item-swatch"
                          : i.selected
                          ? "window-item-text text-selected"
                          : "window-item-text"
                      }
                    >
                      {a.type !== "swatch" ? i.value : ""}
                    </div>
                  ))}
                </div>
              </div>
            ))}
          </div>
        </div>
        <div className="window-gallery">
          <div className="quantity">
            <div
              data-testid="cart-item-amount-increase"
              className="pm"
              onClick={() => {
                this.props.increase(product);
                this.setState({
                  quantity: this.state.quantity + 1,
                });
              }}
            >
              +
            </div>
            <div id="quantity" data-testid="cart-item-amount">
              {this.props.product.quantity}
            </div>
            <div
              data-testid="cart-item-amount-decrease"
              className="pm"
              onClick={() => {
                this.props.decrease(product);
                this.setState({
                  quantity: this.state.quantity - 1,
                });
              }}
            >
              -
            </div>
          </div>
          <img
            src={product.gallery[0]}
            alt="main-img"
            className="window-img"
          ></img>
        </div>
      </div>
    );
  }
}

const mapStateToProps = (state) => ({
  currency: state.currencyReducer.currency,
  currencies: state.currencyReducer.currencies,
});

const mapDispatchToProps = {
  increase,
  decrease,
  setQuantity,
};

export default connect(mapStateToProps, mapDispatchToProps)(CartWindowItem);
