import React, { Component } from "react";
import "./Spinner.css";

export default class Spinner extends Component {
  render() {
    const style = {
      width: this.props.width,
      height: this.props.width,
    };

    return <div className="spinner" style={style}></div>;
  }
}
