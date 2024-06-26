import React, { Component } from "react";
import carticon from "../../images/circle-icon.png";
import { withRouter } from "../../utils/HOC";
import { connect } from "react-redux";
import { addToCart } from "../../state/actions/cartAction";
import { client, product } from "../../utils/queries";
import "./ProductCard.css";
import Attribute from "./Attribute";
import { toKebabCase } from "../../utils/helpers";

class ProductCard extends Component {
  constructor(props) {
    super(props);

    this.state = {
      title: props.title,
      instock: this.props.instock,
      product: this.props.prod,
      showAttributeSelect: false,
      attributes: [],
    };
  }

  async getProduct() {
    const id = this.state.product.id;
    const query = product(id);

    const res = await client.query({ query: query });

    const attributes = res.data.product.attributes;

    this.setState({ product: res.data.product });
    this.setState({ attributes: attributes });
  }

  componentDidMount() {
    this.getProduct();
  }

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
    const prod = this.state.product;
    if (this.allSelected()) {
      this.props.addToCart({
        ...prod,
        quantity: 1,
        attributes: this.state.attributes,
      });
      this.setState({ showAttributeSelect: false });
    }
  }

  render() {
    const productNameInKebabCase = toKebabCase(this.state.product.name);

    return (
      <>
        {this.state.showAttributeSelect && (
          <div
            className="attributes-modal"
            onClick={() => this.setState({ showAttributeSelect: false })}
          >
            <div
              className="attribte-modal-content"
              onClick={(e) => {
                e.stopPropagation();
              }}
            >
              <div className="attributes">
                {this.state.attributes?.map((a, i) => (
                  <Attribute
                    key={i}
                    attribute={a}
                    selectItem={this.selectItem.bind(this)}
                  />
                ))}
              </div>
              <div className="add_to_cart" onClick={() => this.onAddToCart()}>
                ADD TO CART
              </div>
            </div>
          </div>
        )}
        <div
          className="card"
          data-testid={`product-${productNameInKebabCase}`}
          onClick={() => {
            this.props.navigate("/product/" + this.props.prod.id);
          }}
        >
          {!this.props.instock && (
            <div id="overlay" className="pdp-overlay">
              <div id="text">OUT OF STOCK</div>
            </div>
          )}
          <div className="card-img-container">
            <img className="card-img" src={this.props.img} alt="" />
          </div>
          {this.props.instock && (
            <img
              className="card-cart-icon"
              src={carticon}
              alt=""
              onClick={(e) => {
                e.stopPropagation();
                if (this.state.attributes.length === 0) {
                  this.onAddToCart();
                } else {
                  this.setState({ showAttributeSelect: true });
                }
              }}
            />
          )}
          <p>
            {this.props.brand} {this.props.title}
          </p>
          <p id="price">
            {this.props.symb} {this.props.price?.toFixed(2)}
          </p>
        </div>
      </>
    );
  }
}

export default connect(null, { addToCart })(withRouter(ProductCard));
