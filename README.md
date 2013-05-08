Summarizer
==========

PHP class to summarize content into short summary

This class was created to give more intelligent excerpts to job postings on [workerpod.com](http://workerpod.com), but can be used to summarize any content.

It works by analyzing each sentence in each paragraph and returning the most relevant sentence of that paragraph.

You can run demo.php to see it in action, or look at any job posting on [workerpod.com](http://workerpod.com).

## The Summarization Algorithm

Here's a step-bystep explanation of how and why this algorithm works.

### The intersection function:

This function receives two sentences, and returns a score for the intersection between them.

each sentence is split into words, we then count how many common words we have, and then we normalize the result with the average length of the two sentences.

### The sentences dictionary:

This part really is the 'Heart' of the algorithm. It receives our text as input, and calculates a score for each sentence. The calculations is composed of two steps:

1. In the first step we split the text into sentences, and store the intersection value between each two sentences in a two-dimensional array. So values[0][2] will hold the intersection score between sentence #1 and sentence #3.

2. In the second step we calculate an individual score for each sentence and store it in a key-value dictionary, where the sentence itself is the key and the value is the total score. We do that just by summing up all its intersections with the other sentences in the text (not including itself).

### Building the summary:

Obviously, the final step of our algorithm is generating the final summary. We do that by splitting our text into paragraphs, and then we choose the best sentence from each paragraph according to our sentences dictionary which was generated above.

### Why this works

There are two main reasons why this algorithm works: 

The first (and obvious) reason is that a paragraph is a logical atomic unit of the text. In simple words - there is probably a very good reason why the author decided to split his text that way.

The second (and maybe less obvious..) reason is that if two sentences have a good intersection, they probably hold the same information. 

So if one sentence has a good intersection with many other sentences, it probably holds some information from each one of them - or in other words, this is probably a key sentence in our text!