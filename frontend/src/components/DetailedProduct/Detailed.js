import React, { Component } from "react";
import Header from "../Header";
import { client, product } from "../../utils/queries";
import { withRouter } from "../../utils/HOC";
import { connect } from "react-redux";
import { addToCart } from "../../state/actions/cartAction";
import "./Detailed.css";
import Attribute from "../ProductCard/Attribute";
import Slider from "../Slider/Slider";
// import Slider from "./Slider";

class Detailed extends Component {
  constructor(props) {
    super(props);

    this.state = {
      product: {},
      mainImg: "",
      attributes: [],
      selectedCounter: 0,
      imageIndex: 0,
    };
  }

  setImageIndex(arg) {
    this.setState(typeof arg === "function" ? arg : { imageIndex: arg });
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
    if (!(this.state.product.inStock && this.allSelected())) {
      return;
    }
    const tempProd = {
      ...this.state.product,
      attributes: this.state.attributes,
      quantity: 1,
    };
    this.props.addToCart(tempProd);
  }

  render() {
    const prod = this.state.product;

    if (!prod.gallery) {
      return null;
    }

    const images = prod.gallery.map((url, i) => ({
      url,
      alt: "image" + String(i),
    }));

    return (
      <div className="detailed">
        <Header />
        <div className="detailed_inner">
          <div className="bar-imgs">
            {prod.gallery?.map((p, i) => (
              <img
                key={p}
                src={p}
                alt="img"
                className="bar-img"
                onClick={() => this.setImageIndex(i)}
              />
            ))}
          </div>
          <div className="main-img-container">
            {!prod.inStock && (
              <div id="overlay">
                <div id="text">OUT OF STOCK</div>
              </div>
            )}
            <Slider
              images={images}
              setImageIndex={this.setImageIndex.bind(this)}
              imageIndex={this.state.imageIndex}
            />
          </div>
          <div className="info">
            <div className="info_header">
              <h1 id="brand">{prod.brand}</h1>
              <h1 id="name">{prod.name}</h1>
            </div>
            <div className="attributes">
              {this.state.attributes?.map((a, i) => (
                <Attribute
                  key={i}
                  attribute={a}
                  selectItem={this.selectItem.bind(this)}
                />
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
            <div
              className={`add_to_cart ${
                !(this.state.product.inStock && this.allSelected()) &&
                "disabled"
              }`}
              onClick={() => this.onAddToCart()}
            >
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
  cart: state.cartReducer.cart,
});

export default connect(mapStateToProps, { addToCart })(withRouter(Detailed));
