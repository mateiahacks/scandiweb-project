// Function to compare product objects deeply to avoid same products with the same attributes
function deepEqual(object1, object2) {
  const keys1 = Object.keys(object1);
  const keys2 = Object.keys(object2);
  if (keys1.length !== keys2.length) {
    return false;
  }
  for (const key of keys1) {
    const val1 = object1[key];
    const val2 = object2[key];
    const areObjects = isObject(val1) && isObject(val2);
    if (
      (areObjects && !deepEqual(val1, val2)) ||
      (!areObjects && val1 !== val2)
    ) {
      return false;
    }
  }
  return true;
}

function isObject(object) {
  return object != null && typeof object === "object";
}

const initialState = localStorage.getItem("cart")
  ? JSON.parse(localStorage.getItem("cart"))
  : {
      cart: [],
      totalQuantity: 0,
      totalCost: 0,
      isLoading: false,
    };

let result = null;

export default function cartReducer(state = initialState, action) {
  switch (action.type) {
    case "ADD_TO_CART":
      // if product with same attributes already in cart
      for (let i = 0; i < state.cart.length; i++) {
        if (
          deepEqual(
            { ...state.cart[i], quantity: 0 },
            { ...action.payload, quantity: 0 }
          )
        ) {
          result = {
            ...state,
            cart: state.cart.map((p) =>
              deepEqual(
                { ...p, quantity: 0 },
                { ...state.cart[i], quantity: 0 }
              )
                ? { ...state.cart[i], quantity: state.cart[i].quantity + 1 }
                : p
            ),
            totalQuantity: state.totalQuantity + 1,
          };
          localStorage.setItem("cart", JSON.stringify(result));
          return result;
        }
      }
      result = {
        ...state,
        cart: [...state.cart, action.payload],
        totalQuantity: state.totalQuantity + 1,
      };
      localStorage.setItem("cart", JSON.stringify(result));
      return result;
    case "SET_QUANTITY":
      if (action.payload.quantity === 0) {
        result = {
          ...state,
          cart: state.cart.filter(
            (p) =>
              !deepEqual(
                { ...p, quantity: 0 },
                { ...action.payload, quantity: 0 }
              )
          ),
          totalQuantity: state.totalQuantity - 1,
        };
        localStorage.setItem("cart", JSON.stringify(result));
        return result;
      }
      result = {
        ...state,
        cart: state.cart.map((p) =>
          deepEqual({ ...p, quantity: 0 }, { ...action.payload, quantity: 0 })
            ? action.payload
            : p
        ),
        totalQuantity: state.totalQuantity + action.quantityToAdd,
      };
      localStorage.setItem("cart", JSON.stringify(result));
      return result;
    case "INCREASE":
      result = {
        ...state,
        cart: state.cart.map((p) =>
          deepEqual({ ...p, quantity: 0 }, { ...action.payload, quantity: 0 })
            ? action.payload
            : p
        ),
        totalQuantity: state.totalQuantity + 1,
      };
      localStorage.setItem("cart", JSON.stringify(result));
      return result;
    case "DECREASE":
      //If product quantity in cart appears 0 it will be removed from the cart
      if (action.payload.quantity === 0) {
        result = {
          ...state,
          cart: state.cart.filter(
            (p) =>
              !deepEqual(
                { ...p, quantity: 0 },
                { ...action.payload, quantity: 0 }
              )
          ),
          totalQuantity: state.totalQuantity - 1,
        };
        localStorage.setItem("cart", JSON.stringify(result));
        return result;
      }
      result = {
        ...state,
        cart: state.cart.map((p) =>
          deepEqual({ ...p, quantity: 0 }, { ...action.payload, quantity: 0 })
            ? action.payload
            : p
        ),
        totalQuantity: state.totalQuantity - 1,
      };
      localStorage.setItem("cart", JSON.stringify(result));
      return result;
    case "RESET_CART":
      localStorage.removeItem("cart");
      return {
        cart: [],
        totalQuantity: 0,
        totalCost: 0,
        isLoading: false,
      };
    case "SET_CREATING_ORDER":
      return {
        ...state,
        isLoading: action.payload,
      };
    default:
      return state;
  }
}
