export function toKebabCase(str) {
  let result = "";

  for (let i = 0; i < str.length; i++) {
    const char = str[i];
    const lowerChar = char.toLowerCase();

    if (char !== lowerChar) {
      // This is an uppercase letter, prepend with a hyphen if not at the start
      if (i !== 0) {
        result += "-";
      }
      result += lowerChar;
    } else if (char === " ") {
      // Replace spaces with hyphens
      result += "-";
    } else if (
      (char >= "a" && char <= "z") ||
      (char >= "0" && char <= "9") ||
      char === "-"
    ) {
      // Append lowercase letters, digits, and hyphens as is
      result += char;
    }
    // Ignore all other characters
  }

  // Replace multiple hyphens with a single hyphen
  result = result.split("-").filter(Boolean).join("-");

  return result;
}
