from collections import namedtuple
from math import sqrt

import os
import random

from PIL import Image, ImageFilter

Point = namedtuple('Point', ('coords', 'n', 'ct'))
Cluster = namedtuple('Cluster', ('points', 'center', 'n'))

def prepare_images():
    dest_folder = '/home/listing-manager/public_html/wordpress/wp-content/uploadz/'

    for root, dirs, files in os.walk(dest_folder):
        for file in files:
            extension = file.split('.')[-1]
            if extension in ['jpg', 'png', 'jpeg']:
                if extension == 'jpg':
                    extension = 'jpeg'

                path = root + '/' + file
                print path

                im = Image.open(path)
                size = im.size
                # size = (1, 1)

                try:
                    colors = colorz(path, 1)
                except TypeError:
                    colors = ('#000000', )

                new_im = Image.new('RGB', size, colors[0])
                new_im.save(path, extension, optimize=True, quality=1)


def get_points(img):
    points = []
    w, h = img.size
    for count, color in img.getcolors(w * h):
        points.append(Point(color, 3, count))
    return points


rtoh = lambda rgb: '#%s' % ''.join(('%02x' % p for p in rgb))


def colorz(filename, n=3):
    img = Image.open(filename)
    img.thumbnail((200, 200))
    w, h = img.size

    points = get_points(img)
    clusters = kmeans(points, n, 1)
    rgbs = [map(int, c.center.coords) for c in clusters]
    return map(rtoh, rgbs)


def euclidean(p1, p2):
    return sqrt(sum([
        (p1.coords[i] - p2.coords[i]) ** 2 for i in range(p1.n)
    ]))


def calculate_center(points, n):
    vals = [0.0 for i in range(n)]
    plen = 0
    for p in points:
        plen += p.ct
        for i in range(n):
            vals[i] += (p.coords[i] * p.ct)
    return Point([(v / plen) for v in vals], n, 1)


def kmeans(points, k, min_diff):
    clusters = [Cluster([p], p, p.n) for p in random.sample(points, k)]

    while 1:
        plists = [[] for i in range(k)]

        for p in points:
            smallest_distance = float('Inf')
            for i in range(k):
                distance = euclidean(p, clusters[i].center)
                if distance < smallest_distance:
                    smallest_distance = distance
                    idx = i
            plists[idx].append(p)

        diff = 0
        for i in range(k):
            old = clusters[i]
            center = calculate_center(plists[i], old.n)
            new = Cluster(plists[i], center, old.n)
            clusters[i] = new
            diff = max(diff, euclidean(old.center, new.center))

        if diff < min_diff:
            break

    return clusters


prepare_images()