Summarizer
==========

PHP class to summarize content into short summary


This class was created to give more intelligent excerpts to job postings on workerpod.com, but can be used to summarize any content.

## Summarization Technologies

Today there are two common approaches to 'attacking' the summarization mission. The first approach tries to analyze the text, and to rewrite or rephrase it in a short way. As far as I know, until today this approach didn't achieve any substantial results. The second approach ,which is similar to my naive algorithm, tries to extract the key sentences from the text, and then tries to put them together properly. One famous algorithm that implements this approach is TextRank.

## Our Summarization Algorithm

I'm going to explain step-by-step my naive algorithm. I'll use both programming and computer science terminology. Before you continue, in case you didn't do it already, I suggest to to take a quick look at the code.

## The intersection function:

This function receives two sentences, and returns a score for the intersection between them.

We just split each sentence into words/tokens, count how many common tokens we have, and then we normalize the result with the average length of the two sentences.

Computer Science: f(s1, s2) = |{w | w in s1 and w in s2}| / ((|s1| + |s2|) / 2)

## The sentences dictionary:

This part is actually the 'Heart' of the algorithm. It receives our text as input, and calculates a score for each sentence. The calculations is composed of two steps:

In the first step we split the text into sentences, and store the intersection value between each two sentences in a matrix (two-dimensional array). So values[0][2] will hold the intersection score between sentence #1 and sentence #3.
Computer Science: In fact, we just converted our text into a fully-connected weighted graph! Each sentence is a node in the graph and the two-dimensional array holds the weight of each edge!

In the second step we calculate an individual score for each sentence and store it in a key-value dictionary, where the sentence itself is the key and the value is the total score. We do that just by summing up all its intersections with the other sentences in the text (not including itself).
Computer Science: We calculates the score for each node in our graph. We simply do that by summing all the edges that are connected to the node.

## Building the summary:

Obviously, the final step of our algorithm is generating the final summary. We do that by splitting our text into paragraphs, and then we choose the best sentence from each paragraph according to our sentences dictionary.
Computer Science: The Idea here is that every paragraph in the text represents some logical subset of our graph, so we just pick the most valuable node from each subset!

## Why this works

There are two main reasons why this algorithm works: The first (and obvious) reason is that a paragraph is a logical atomic unit of the text. In simple words ' there is probably a very good reason why the author decided to split his text that way. The second (and maybe less obvious..) reason is that if two sentences have a good intersection, they probably holds the same information. So if one sentence has a good intersection with many other sentences, it probably holds some information from each one of them- or in other words, this is probably a key sentence in our text!