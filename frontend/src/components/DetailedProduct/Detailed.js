import React, { Component } from "react";
import Header from "../Header";
import { client, product } from "../../utils/queries";
import { withRouter } from "../../utils/HOC";
import { connect } from "react-redux";
import { addToCart } from "../../actions/cartAction";
import "./Detailed.css";

class Detailed extends Component {
  constructor(props) {
    super(props);

    this.state = {
      product: {},
      mainImg: "",
      attributes: [],
      selectedCounter: 0,
    };
  }

  async getProduct() {
    const { id } = this.props.params;
    const query = product(id);

    const res = await client.query({ query: query });

    const attributes = res.data.product.attributes;

    this.setState({ product: res.data.product });
    this.setState({ mainImg: res.data.product.gallery[0] });
    this.setState({ attributes: attributes });

    // parsing from string to html document
    const parser = new DOMParser();
    const doc = parser.parseFromString(
      res.data.product.description,
      "text/html"
    );

    // then selecting actual description element inside body
    const el = doc.querySelector("body > *");
    const parent = document.querySelector(".info");
    el.id = "description";

    //adding current element to product info
    parent.appendChild(el);
  }

  componentDidMount() {
    this.getProduct();
  }

  // selecting item of attribute attr and storing it in temporary product state
  selectItem(attr, item) {
    const attributes = this.state.attributes;
    this.setState({
      attributes: attributes.map((a) => {
        if (a.id === attr.id) {
          return {
            ...a,
            items: a.items.map((i) =>
              i.id === item.id
                ? { ...i, selected: true }
                : { ...i, selected: false }
            ),
          };
        }
        return a;
      }),
    });
  }

  allSelected() {
    const attributes = this.state.attributes;
    let selectedCount = 0;
    for (const attribute of attributes) {
      for (const item of attribute.items) {
        if (item.selected === true) selectedCount++;
      }
    }
    return selectedCount === attributes.length;
  }

  onAddToCart() {
    const out_err_msg = document.getElementById("out-err");
    const attr_err_msg = document.getElementById("attr-err");
    const tempProd = {
      ...this.state.product,
      attributes: this.state.attributes,
      quantity: 1,
    };
    if (this.state.product.inStock && this.allSelected()) {
      this.props.addToCart(tempProd);
      out_err_msg.style.display = "none";
      attr_err_msg.style.display = "none";
    } else {
      !this.state.product.inStock
        ? (out_err_msg.style.display = "block")
        : (attr_err_msg.style.display = "block");
    }
  }

  render() {
    const prod = this.state.product;

    return (
      <div className="detailed">
        <Header />
        <div className="detailed_inner">
          <div className="bar-imgs">
            {prod.gallery?.map((p) => (
              <img
                key={p}
                src={p}
                alt="img"
                className="bar-img"
                onClick={() => this.setState({ mainImg: p })}
              />
            ))}
          </div>
          <div className="main-img-container">
            {!prod.inStock && (
              <div id="overlay">
                <div id="text">OUT OF STOCK</div>
              </div>
            )}
            <img className="main-img" src={this.state.mainImg} alt="" />
          </div>
          <div className="info">
            <div className="info_header">
              <h1 id="brand">{prod.brand}</h1>
              <h1 id="name">{prod.name}</h1>
            </div>
            <div className="attributes">
              {this.state.attributes?.map((a) => (
                <div key={a.id} className="attribute">
                  <h3>{a.name?.toUpperCase()} :</h3>
                  <div className="items">
                    {a.items.map((i) => (
                      <div
                        onClick={() => this.selectItem(a, i)}
                        key={i.id}
                        style={{
                          backgroundColor: i.value,
                          border:
                            i.displayValue === "White" ? "1px solid black" : "",
                        }}
                        className={
                          a.type === "swatch"
                            ? i.selected
                              ? "item-swatch swatch-selected"
                              : "item-swatch"
                            : i.selected
                            ? "item-text text-selected"
                            : "item-text"
                        }
                      >
                        {a.type === "swatch" ? "" : i.value}
                      </div>
                    ))}
                  </div>
                </div>
              ))}
            </div>
            <h3>PRICE:</h3>
            <h2 className="price">
              {prod.prices &&
                this.props.currency.symbol +
                  " " +
                  prod?.prices[
                    this.props.currencies.indexOf(this.props.currency)
                  ]?.amount?.toFixed(2)}
            </h2>
            <div className="add_to_cart" onClick={() => this.onAddToCart()}>
              ADD TO CART
            </div>
            <p className="error" id="out-err">
              *out of stock
            </p>
            <p className="error" id="attr-err">
              *select all attributes
            </p>
            <div id="description" />
          </div>
        </div>
      </div>
    );
  }
}

const mapStateToProps = (state) => ({
  currency: state.currencyReducer.currency,
  currencies: state.currencyReducer.currencies,
});

export default connect(mapStateToProps, { addToCart })(withRouter(Detailed));
