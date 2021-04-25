/* Regex (ECMAScript) */

/* Character classes */
/\b\d{4}\b/g  // Make sure not to start the match in a middle of a word
/\b[aA]\w+/g  // Similar to /\s([aA]\w+)/g but better
// There also is /B
/[.]/  // . is treated as a "." when in []

/* Assertions */
/x(?=[y-z])/  // Lookahead. match x that is followed by y or z
/x(?![y-z])/  // Negative lookahead
/(?<=y)x/  // Lookbehind
/(?<!y)x/  // Negative lookbehind

/* Groups and ranges */
/(?:x)/  // non capturing group
// Back reference (reusing matched groups):
/\w+(, ?|;)(?:\w+\1)+\w*/  // match a comma or semicolon delimited list
/\w+(?<delim>, ?|;)(?:\w+\k<delim>)+\w*/  // same, but using named groups

/* Quantifiers */
/x{n,}/  // [n,inf)
/x*?/  // /x{n,m}?  // non-greedy - match as little as posible

/* Unicode */
/\p{Number}/
/\p{Letter}/u  // /\p{L}/u  // /\p{General_Category=Letter}/u
/\p{Script=Latin}/u  // Greek|Cyrillic
// \P for negation

/* Flags */
/^m$/m  // match end and beggining of line instead of entire string
/a/d.exec('str');  // provide array of .indices in the match object
const rDigit = /\d/y;  // sticky - start next after last index
rDigit.lastIndex = 10;  // begin match at the 10th digit (unpure)
// Return array of all matches with indices (pure):
[...'str'.matchAll(/\w/dg)]

/* Replacements */
`
$1  // first match
$&  // complete match
$'  // everything before match
`

/* Good Practices */
(/.*/, /[^"]*/)  // exclude instead of match all
(/<.*?>/, /<[^>]+>/)  // match all ">" untill first occurence

// It seems like there are a TON of cool Regex features that are missing
// in JavaScript

