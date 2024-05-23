import React, { Component } from "react";
import { toKebabCase } from "../../utils/helpers.js";

export default class Attribute extends Component {
  select(a, i) {
    if (!this.props.selectItem) {
      return;
    }
    this.props.selectItem(a, i);
  }

  render() {
    const a = this.props.attribute;

    return (
      <div
        key={a.id}
        className="attribute"
        data-testid={`product-attribute-${toKebabCase(a.name)}`}
      >
        <h3>{a.name?.toUpperCase()} :</h3>
        <div className="items">
          {a.items.map((i) => (
            <div
              key={i.id}
              onClick={() => this.select(a, i)}
              style={{
                backgroundColor: i.value,
                border: i.displayValue === "White" ? "1px solid black" : "",
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
    );
  }
}
