import { client, createOrderMutation } from "../../utils/queries";

// decreasing specific product quantity
export const decrease = (prod) => (dispatch) => {
  dispatch({
    type: "DECREASE",
    payload: { ...prod, quantity: prod.quantity - 1 },
  });
};

// increasing specific product quantity
export const increase = (prod) => (dispatch) => {
  dispatch({
    type: "INCREASE",
    payload: { ...prod, quantity: prod.quantity + 1 },
  });
};

export const setQuantity = (prod, q) => (dispatch) => {
  dispatch({
    type: "SET_QUANTITY",
    payload: { ...prod, quantity: q },
    quantityToAdd: q - prod.quantity,
  });
  console.log("quant");
};

// adding product to cart
export const addToCart = (prod) => (dispatch) => {
  dispatch({
    type: "ADD_TO_CART",
    payload: prod,
  });
};

// Reseting cart when ordering
export const resetCart = () => (dispatch) => {
  dispatch({
    type: "RESET_CART",
  });
};

// Create order
export const createOrder = (items) => {
  return (dispatch) => {
    const mutation = createOrderMutation(items);
    dispatch({
      type: "SET_CREATING_ORDER",
      payload: true,
    });
    client
      .mutate({
        mutation: mutation,
        variables: { input: items },
      })
      .then((res) => dispatch({ type: "RESET_CART" }))
      .catch((err) => console.log(err));
  };
};
