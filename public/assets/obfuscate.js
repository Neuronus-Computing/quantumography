const JavaScriptObfuscator = require('javascript-obfuscator');
const fs = require('fs');

// Specify the JavaScript file(s) to obfuscate
const jsFiles = [
//   './js/custom.js',
  // Add more files if needed
];

// Obfuscate each JavaScript file
jsFiles.forEach((file) => {
  const filePath = `${__dirname}/${file}`;
  const fileContent = fs.readFileSync(filePath, 'utf-8');

  const obfuscatedContent = JavaScriptObfuscator.obfuscate(fileContent, {
    // Obfuscator options
  }).getObfuscatedCode();

  fs.writeFileSync(filePath, obfuscatedContent, 'utf-8');
});
