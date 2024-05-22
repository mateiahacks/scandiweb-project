import React, { Component } from "react";
import Header from "../Header";
import ProductCard from "../ProductCard/ProductCard";
import { connect } from "react-redux";
import { fetchProducts } from "../../state/actions/productsAction";
import "./Home.css";
import { withRouter } from "../../utils/HOC";

class Home extends Component {
  componentDidMount() {
    this.props.fetchProducts(this.props.params.category_name);
  }

  componentDidUpdate() {
    this.props.fetchProducts(this.props.params.category_name);
  }

  capitalizeFirstLetter = ([first, ...rest], locale = navigator.language) =>
    first.toLocaleUpperCase(locale) + rest.join("");

  render() {
    return (
      <div className="home">
        <Header />
        <div className="home__inner" id="home">
          <h1>
            {this.props.params.category_name &&
              this.capitalizeFirstLetter(this.props.params.category_name)}
          </h1>
          <div className="products">
            {this.props.products &&
              this.props.products.map((e) => (
                <ProductCard
                  key={e.id}
                  prod={e}
                  title={e.name}
                  img={e.gallery[0]}
                  price={
                    e.prices[this.props.currencies.indexOf(this.props.currency)]
                      ?.amount
                  }
                  symb={this.props.currency.symbol}
                  brand={e.brand}
                  id={e.id}
                  instock={e.inStock}
                />
              ))}
          </div>
        </div>
      </div>
    );
  }
}

const mapStateToProps = (state) => ({
  currentCategory: state.categoryReducer.category,
  products: state.productsReducer.products,
  currencies: state.currencyReducer.currencies,
  currency: state.currencyReducer.currency,
});

export default connect(mapStateToProps, { fetchProducts })(withRouter(Home));
