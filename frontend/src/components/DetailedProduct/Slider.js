import React, { Component } from "react";
import arrow from "../../images/right-arrow.png";

class Slider extends Component {
  constructor(props) {
    super(props);

    this.state = {
      counter: 2,
    };
  }

  // function for slide to next photo in gallery
  next() {
    const el =
      document.querySelectorAll(".cart-prod-img")[
        this.props.cart.indexOf(this.props.prod)
      ];
    if (this.state.counter === this.state.images.length + 1) {
      el.style.transition = "transform 0.4s ease-in-out";
      el.style.transform = "translateX(" + -300 * this.state.counter + "px)";
      this.setState({ counter: this.state.count + 1 });
      el.style.transition = "none";
      el.style.transform =
        "translateX(" +
        -300 * (this.state.counter - this.state.images.length) +
        "px)";
      this.setState({ counter: 2 });
    } else {
      //console.log(this.state.counter);
      el.style.transition = "transform 0.4s ease-in-out";
      this.setState({ counter: this.state.counter + 1 });
      el.style.transform = "translateX(" + -300 * this.state.counter + "px)";
    }
  }

  // function for slide to previous photo in gallery
  prev() {
    const el =
      document.querySelectorAll(".cart-prod-img")[
        this.props.cart.indexOf(this.props.prod)
      ];
    if (this.state.counter === 2) {
      el.style.transition = "transform 0.4s ease-in-out";
      el.style.transform =
        "translateX(" + -300 * (this.state.counter - 2) + "px)";
      setTimeout(() => {
        el.style.transition = "none";
        el.style.transform =
          "translateX(" +
          -300 * (this.state.counter + this.state.images.length - 2) +
          "px)";
        this.setState({ counter: this.state.images.length + 1 });
      }, 400);
    } else {
      el.style.transition = "transform 0.4s ease-in-out";
      this.setState({ counter: this.state.counter - 1 });
      el.style.transform =
        "translateX(" + -300 * (this.state.counter - 2) + "px)";
    }
  }

  render() {
    const prod = this.props.product;

    return (
      <div className="slider">
        <div className="cart-gallery-container">
          <div className="cart-prod-img">
            <img
              src={prod.gallery[prod.gallery.length - 1]}
              id="lastClone"
              alt="last-clone"
            />
            {prod.gallery.map((url) => (
              <img key={url} src={url} alt="prod" />
            ))}
            <img src={prod.gallery[0]} id="fistClone" alt="" />
          </div>
          {prod.gallery.length > 1 && (
            <div className="cart-prod-arrows">
              <img
                id="left-arrow"
                src={arrow}
                onClick={() => this.prev()}
                alt="arrow"
              />
              <img
                id="right-arrow"
                src={arrow}
                onClick={() => this.next()}
                alt="arrow"
              />
            </div>
          )}
        </div>
      </div>
    );
  }
}

export default Slider;
