import React, { Component } from "react";
import "./Slider.css";
import arrow from "../../images/right-arrow.png";

class Slider extends Component {
  constructor(props) {
    super(props);

    this.state = {
      imageIndex: 0,
    };
  }

  showPrevImage() {
    this.props.setImageIndex((prevState) => {
      if (prevState.imageIndex === 0) {
        return { imageIndex: this.props.images.length - 1 };
      }
      return { imageIndex: prevState.imageIndex - 1 };
    });
  }

  showNextImage() {
    this.props.setImageIndex((prevState) => {
      if (prevState.imageIndex === this.props.images.length - 1) {
        return { imageIndex: 0 };
      }
      return { imageIndex: prevState.imageIndex + 1 };
    });
  }

  render() {
    const { images, imageIndex } = this.props;

    return (
      <section aria-label="Image Slider" className="slider-section">
        <a href="#after-image-slider-controls" className="skip-link">
          Skip Image Slider Controls
        </a>
        <div className="img-container">
          {images.map(({ url, alt }, index) => (
            <img
              key={url}
              src={url}
              alt={alt}
              aria-hidden={imageIndex !== index}
              className="img-slider-img"
              style={{ translate: `${-100 * imageIndex}%` }}
            />
          ))}
        </div>
        <button
          onClick={this.showPrevImage.bind(this)}
          className="img-slider-btn-left"
          aria-label="View Previous Image"
        >
          <img src={arrow} alt="left-arrow" className="arrow-left" />
        </button>
        <button
          onClick={this.showNextImage.bind(this)}
          className="img-slider-btn-right"
          aria-label="View Next Image"
        >
          <img src={arrow} alt="right-arrow" />
        </button>
        <div id="after-image-slider-controls" />
      </section>
    );
  }
}

export default Slider;
