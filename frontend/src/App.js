import React, { Component } from "react";
import {
  BrowserRouter as Router,
  Routes,
  Route,
  Navigate,
} from "react-router-dom";
import Home from "./components/Home/Home";
import { connect } from "react-redux";
import { fetchCurrencies } from "./state/actions/currencyAction";
import { fetchCategories } from "./state/actions/categoryAction";
import Detailed from "./components/DetailedProduct/Detailed";

class App extends Component {
  componentDidMount() {
    this.props.fetchCategories();
    this.props.fetchCurrencies();
  }

  render() {
    if (this.props.categories.length === 0) {
      return null;
    }
    return (
      <Router>
        <Routes>
          <Route
            path="/"
            element={
              <Navigate to={`/category/${this.props.categories[0].name}`} />
            }
          />
          <Route path="/category/:category_name" element={<Home />} />
          <Route path="/product/:id" element={<Detailed />} />
        </Routes>
      </Router>
    );
  }
}

const mapStateToProps = (state) => ({
  categories: state.categoryReducer.categories,
  currencies: state.currencyReducer.currencies,
  cart: state.cartReducer.cart,
});

const mapDispatchToProps = {
  fetchCurrencies,
  fetchCategories,
};

export default connect(mapStateToProps, mapDispatchToProps)(App);
